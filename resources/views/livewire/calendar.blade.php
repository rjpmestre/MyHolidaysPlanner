<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="row pt-3">
        <div class="col-6">
            <button class="btn btn-tools" wire:click="previousYear">&lt;</button>
            <strong>{{ $currentYear }}</strong>
            <button class="btn btn-tools" wire:click="nextYear">&gt;</button>
        </div>

        <div class="col-6 text-right">
            <h4>Dias:
                @if ($totalDaysSelected > $maxVacationDays)
                    <span class="text-danger"><strong>{{ $totalDaysSelected }}</strong></span>
                @else
                    {{ $totalDaysSelected }}
                @endif
                / {{ $maxVacationDays }}
            </h4>
        </div>
    </div>
    <div class="row pb-3">

        <div class="col-6">
            @foreach($warnings as $warning)
                <p class="text-warning mb-0">

                    <i class="fas fa-exclamation-circle" ></i>
                    {{ $warning }}
                </p>
            @endforeach
        </div>

        <div class="col-6 text-right d-flex justify-content-end align-items-center">
            <div class="d-inline-flex align-items-center mr-3">
                <span class="mr-2">Selecionar Pontes:</span>
                <button class="btn btn-primary ml-1" wire:click="selectBridges(1)">1</button>
                <button class="btn btn-primary ml-1" wire:click="selectBridges(2)">2</button>
                <button class="btn btn-primary ml-1" wire:click="selectBridges(3)">3</button>
                <button class="btn btn-primary ml-1" wire:click="selectBridges(4)">4</button>
            </div>

            <button type="button" class="btn btn-tool" wire:click="restoreVacationDays" title="Restaurar" >
                <i class="fas fa-sync"></i>
            </button>

            <button type="button" class="btn btn-tool" wire:click="clearVacationDays" title="Limpar">
                <i class="fas fa-eraser"></i>
            </button>

            <button type="button" class="btn btn-tool" wire:click="saveVacationDays" title="Guardar">
                <i class="fa fa-save"></i>
            </button>
        </div>

    </div>

    <div class="row">
        @for ($month = 1; $month <= 12; $month++)
            <div class="col-4" wire:key="month-{{ $month }}-{{ $currentYear }}">
                <div class="card calendar">
                    <div class="card-header text-uppercase text-center py-2">
                        {{ Carbon\Carbon::createFromDate($currentYear, $month, 1)->locale('pt_PT')->monthName }}
                        <span class="badge badge-light">{{ collect($selectedDays)->filter(function($day) use ($month) {
                            return Carbon\Carbon::parse($day)->month == $month;
                        })->count() }}</span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="px-0 py-2">Do</th>
                                    <th class="px-0 py-2">Se</th>
                                    <th class="px-0 py-2">Te</th>
                                    <th class="px-0 py-2">Qu</th>
                                    <th class="px-0 py-2">Qu</th>
                                    <th class="px-0 py-2">Se</th>
                                    <th class="px-0 py-2">Sá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $daysInMonth = Carbon\Carbon::createFromDate($currentYear, $month, 1)->daysInMonth;
                                    $firstDayOfMonth = Carbon\Carbon::createFromDate($currentYear, $month, 1)->dayOfWeek;
                                @endphp
                                <tr>
                                    @for ($i = 0; $i < $firstDayOfMonth; $i++)
                                        <td></td>
                                    @endfor

                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        @php
                                            $date = Carbon\Carbon::createFromDate($currentYear, $month, $day);
                                            $holidays = $this->getHolidays($date->format('Y-m-d'));
                                            $isInGroup = $this->isAlternativeHoliday($date->format('Y-m-d'));
                                            $birthdays = $this->getBirthdays($date->format('Y-m-d'));
                                            $tooltip = $holidays->pluck('description')->merge($birthdays->pluck('description'))->join('<br/>');
                                        @endphp
                                        <td
                                            class="px-0 py-2 {{ $this->getClasses($date->format('Y-m-d'))}}"
                                            wire:click="toggleDay('{{ $date->format('Y-m-d') }}')"
                                            data-date="{{ $date->format('Y-m-d') }}"
                                            @if($tooltip)
                                                data-html="true"
                                                data-toggle="tooltip"
                                                data-title="{{ $tooltip }}"
                                            @endif
                                            @if($isInGroup)
                                                onmouseover="highlightGroup('{{ $date->format('Y-m-d') }}')"
                                                onmouseout="clearHighlight()"
                                            @endif
                                        >
                                            {{ $day }}
                                            @if($holidays->count() + $birthdays->count() > 1)
                                                <span class="badge badge-light">{{ $holidays->count() + $birthdays->count() }}</span>
                                            @endif

                                        @if (($day + $firstDayOfMonth) % 7 == 0)
                                            </tr><tr>
                                        @endif
                                    @endfor

                                    @for ($i = ($firstDayOfMonth + $daysInMonth) % 7; $i < 7 && $i != 0; $i++)
                                        <td></td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    @push('scripts')
        <script>
            // Function to highlight the group dates
            function highlightGroup(date) {
                const groupDates = @json($holidayGroups); // Get group dates from Livewire
                const datesToHighlight = [];

                // Find the group for the hovered date
                for (const group of groupDates) {
                    if (group.dates.includes(date)) {
                        datesToHighlight.push(...group.dates);
                        break;
                    }
                }

                // Highlight the relevant dates with a border
                datesToHighlight.forEach(function(date) {
                    const td = document.querySelector(`td[data-date="${date}"]`);
                    if (td) {
                        td.classList.add('highlight'); // Add a highlight class for borders
                    }
                });
            }

            // Function to clear highlights
            function clearHighlight() {
                const highlightedCells = document.querySelectorAll('td.highlight');
                highlightedCells.forEach(function(cell) {
                    cell.classList.remove('highlight'); // Remove the highlight class
                });
            }
        </script>

    @endpush
</div>
