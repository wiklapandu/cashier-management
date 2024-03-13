import $ from 'jquery';
import Swal from 'sweetalert2'

const handleswalConfirm = () => {
    Livewire.on('swal:confirm', (data) => {
        data = JSON.parse(data);
        Swal.fire({
            title: data.title,
            html: data.text,
            showCancelButton: true,
            confirmButtonText: data.confirmButtonText,
            cancelButtonText: data.cancelButtonText,
            buttonsStyling: false,
            showCloseButton: true,
            imageUrl: '/images/confirm.svg',
            customClass: {
                confirmButton: 'sweet-alert-button confirm-button',
                cancelButton: 'sweet-alert-button cancel-button',
            }
        }).then((result) => {
            if(result.isConfirmed) {
                if(data.event_params) {
                    Livewire.dispatch(data.event, data.event_params);
                } else {
                    Livewire.dispatch(data.event);
                }
            }
        })
    })
}

try {
    handleswalConfirm();
} catch(error) {
    console.log('JS ERROR:', error);
}