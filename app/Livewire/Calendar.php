<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Birthday;
use App\Models\Vacation;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Calendar extends Component
{
    #[Url]
    public $currentYear;

    // related to PT laws
    public $maxVacationDays = 22;
    public $minConsecutiveVacationDays = 10;

    public $totalDaysSelected = 0;

    public $selectableDates = [];
    public $selectedDays = [];

    public $holidays = [];
    public $holidayGroups = [];
    public $weekends = [];
    public $birthdays = [];

    public $warnings = [];

    public function mount() {
        $this->currentYear = $this->currentYear ?? Carbon::now()->year + 1;
        $this->loadData();
    }

    protected function loadData() {
        $this->loadHolidays();
        $this->loadSelectedDays();
        $this->loadHolidayGroups();
        $this->loadWeekends();
        $this->loadBirthdays();
        $this->loadSelectableDates();
        // dd($this->holidays, $this->weekends, $this->birthdays);
    }

    protected function loadHolidays() {
        $this->holidays = Holiday::whereYear('date', $this->currentYear)
            ->with('type')
            ->get()
            ->groupBy(function ($holiday) {
                return Carbon::parse($holiday->date)->format('Y-m-d');
            })->all();
    }

    protected function loadBirthdays() {
        $this->birthdays = Birthday::whereYear('date', $this->currentYear)
            ->get()
            ->groupBy(function ($holiday) {
                return Carbon::parse($holiday->date)->format('Y-m-d');
            })->all();
    }

    protected function loadSelectedDays() {
        $this->selectedDays = Vacation::whereYear('date', $this->currentYear)
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })->toArray();

        $this->totalDaysSelected = count($this->selectedDays);
    }

    protected function loadHolidayGroups() {
        $this->holidayGroups = Holiday::whereYear('date', $this->currentYear)
        ->with('type')
        ->whereNotNull('group_id')
        ->get()
        ->groupBy('group_id')
        ->map(function ($holidays) {
            return [
                'dates' => $holidays->pluck('date')->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                })->toArray(),
            ];
        })->values()->toArray(); // Convert to an array of groups
    }

    protected function loadSelectableDates() {
        $nonMovable = Holiday::whereYear('date', $this->currentYear)
            ->whereNull('group_id')
            ->get()
            ->groupBy(function ($holiday) {
                return Carbon::parse($holiday->date)->format('Y-m-d');
            })->all();
        $nonMovableDates = array_keys($nonMovable);
        $nonSelectableDays = array_merge($this->weekends, $nonMovableDates);

        $this->selectableDates = [];

        $startOfYear = Carbon::createFromDate($this->currentYear, 1, 1);
        $endOfYear = Carbon::createFromDate($this->currentYear, 12, 31);

        for ($date = $startOfYear->copy(); $date->lte($endOfYear); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');

            if (!in_array($formattedDate, $nonSelectableDays)) {
                $this->selectableDates[] = $formattedDate;
            }
        }
    }


    public function getClasses($date) {
        if (in_array($date, $this->selectedDays)){
            return implode(' ', ['bg-warning', 'font-weight-bold']);
        }
        if($this->isNationalHoliday($date)){
            return 'national_holiday';
        }
        if($this->isAlternativeHoliday($date)){
            return 'alternative_holiday';
        }
        if($this->isCompanyHoliday($date)){
            return 'company_holiday';
        }
        if(count($this->getBirthDays($date))>0){
            return 'birthday';
        }
        if($this->isWeekend($date)){
            return 'weekend';
        }
        return 'selectable_day';
    }

    public function toggleDay($date) {
        if (!$this->isSelectableDate($date)) {
            return;
        }

        if (in_array($date, $this->selectedDays)) {
            $this->selectedDays = array_diff($this->selectedDays, [$date]);
        } else{
            $this->selectedDays[] = $date;
        }
    }

    public function isNationalHoliday($date) {
        if(!isset($this->holidays[$date])){
            return false;
        }
        return $this->holidays[$date][0]->type_id === 1 && $this->holidays[$date][0]->group_id === null;
    }

    public function isAlternativeHoliday($date) {
        if(!isset($this->holidays[$date])){
            return false;
        }
        return $this->holidays[$date][0]->group_id !== null;
    }

    public function isCompanyHoliday($date) {
        if(!isset($this->holidays[$date])){
            return false;
        }
        return $this->holidays[$date][0]->type_id === 2;
    }

    public function getBirthDays($date) {
        return $this->birthdays[$date] ?? collect();
    }

    public function isSelectableDate($date) {
        return in_array($date, $this->selectableDates);
    }

    public function isWeekend($date) {
        return in_array($date, $this->weekends);
    }

    public function getHolidays($date){
        return $this->holidays[$date] ?? collect();
    }

    public function restoreVacationDays(){
        $this->loadSelectedDays();
    }

    public function clearVacationDays() {
        $this->selectedDays = [];
    }

    public function saveVacationDays(){
        Vacation::whereYear('date', $this->currentYear)->delete();
        foreach ($this->selectedDays as $day) {
            Vacation::create(['date' => $day]);
        }
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Calendário guardado com sucesso!']);
    }

    public function previousYear() {
        $this->currentYear--;
        $this->loadData();
    }

    public function nextYear() {
        $this->currentYear++;
        $this->loadData();
    }

    public function render() {
        $this->totalDaysSelected = count($this->selectedDays);
        $this->checkWarnings();
        return view('livewire.calendar');
    }

    public function checkWarnings() {
        $this->warnings = [];
        if ($this->totalDaysSelected > $this->maxVacationDays) {
            $this->warnings[] = 'O número de dias de férias selecionados excede o limite de '.$this->maxVacationDays.' dias.';
        }
        if (!$this->hasConsecutiveVacationDays($this->minConsecutiveVacationDays)) {
            $this->warnings[] = 'O gozo do período de férias pode ser interpolado, por acordo entre empregador e trabalhador, desde que
sejam gozados, no mínimo, 10 dias úteis consecutivo.';
        }
        log::alert('checkWarnings : '.count($this->warnings));
    }

    public function selectBridges($maxDays) {
        $this->selectedDays = [];

        $nonMovableHolidays = Holiday::whereYear('date', $this->currentYear)->whereNull('group_id')
        ->with('type')
        ->get()
        ->groupBy(function ($holiday) {
            return Carbon::parse($holiday->date)->format('Y-m-d');
        })->all();
        $holidayDates = collect(array_keys($nonMovableHolidays));

        // Merge selected vacation days, weekends, and holidays to create "off days"
        $offDays = collect($this->selectedDays)
            ->merge($holidayDates)
            ->merge($this->weekends)
            ->sort()
            ->unique()
            ->values();

        $daysToFill = [];

        // Iterate through the off days to find the gaps
        for ($i = 0; $i < count($offDays) - 1; $i++) {
            $currOffDay = Carbon::parse($offDays[$i]);
            $nextOffDay = Carbon::parse($offDays[$i + 1]);

            // Calculate the difference between two off days
            $daysBetween = $currOffDay->diffInDays($nextOffDay) - 1;

            // Check if the number of days between the two offdays is less than or equal to $maxDays
            if ($daysBetween > 0 && $daysBetween <= $maxDays) {
                $bridgeDays = [];
                for ($date = $currOffDay->copy()->addDay(); $date->lt($nextOffDay); $date->addDay()) {
                    $bridgeDays[] = $date->format('Y-m-d');
                }
                array_push($daysToFill, ...$bridgeDays);
            }
        }

        // Add the bridge days to the selected vacation days
        $this->selectedDays = array_merge($this->selectedDays, $daysToFill);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Pontes até '.$maxDays.' dias selecionadas.']);
    }

    protected function loadWeekends ()
    {
        $this->weekends = [];

        // Loop through all the days of the year
        $startDate = Carbon::createFromDate($this->currentYear, 1, 1);
        $endDate = Carbon::createFromDate($this->currentYear, 12, 31);

        while ($startDate->lte($endDate)) {
            // Check if the day is Saturday or Sunday
            if ($startDate->isWeekend()) {
                $this->weekends[] = $startDate->format('Y-m-d');
            }
            $startDate->addDay();
        }
    }

    public function hasConsecutiveVacationDays(int $minDays)
    {
        // Ensure selectableDates are sorted in ascending order
        $consecutiveCount = 0;

        // Iterate through the sorted selectable dates
        for ($i = 0; $i < count($this->selectableDates) - 1; $i++) {
            $currentDay = Carbon::parse($this->selectableDates[$i]);
            $nextDay = Carbon::parse($this->selectableDates[$i + 1]);

            // If both currentDay and nextDay are selected and no non-working days in between
            if (in_array($currentDay->format('Y-m-d'), $this->selectedDays) &&
                in_array($nextDay->format('Y-m-d'), $this->selectedDays)) {

                $consecutiveCount++;
            } else {
                // Reset the count if we find a break
                $consecutiveCount = 0;
            }

            // If the count reaches or exceeds $minDays - 1 (minDays consecutive)
            if ($consecutiveCount >= $minDays - 1) {
                return true;  // There are at least $minDays consecutive vacation days
            }
        }

        // If no such block of days is found, return false
        return false;
    }

}
