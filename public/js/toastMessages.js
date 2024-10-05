Livewire.on('toast', (data) => {
    let icon =  data[0].type =='success' ? 'far': 'fa';
    let iconVariant =  data[0].type =='success' ? 'fa-check-circle':'fa-exclamation-circle';

    $(document).Toasts('create', {
        title: data[0].message,
        autohide: true,
        delay: 5000,
        class: 'text-'+data[0].type,
        icon: iconVariant+' ' + icon + ' fa-lg text-'+data[0].type
    })
});
