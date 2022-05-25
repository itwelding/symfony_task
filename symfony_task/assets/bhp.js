// adding new participant row to table on /bhp/add
const new_participant_btn = document.getElementById('add_new_bhp_participant');
const participants_table = document.getElementById('bhp_participants_table');

if(new_participant_btn) {
    new_participant_btn.addEventListener('click', function() {        
        let number_of_rows = participants_table.rows.length;        
        let new_row = participants_table.insertRow(number_of_rows);
        new_row.innerHTML = `
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <input name="participant_name_${number_of_rows}" type="text" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <input name="participant_company_${number_of_rows}" type="text" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                </td>
            </tr>
        `
    });
}


// adding new participant row with signature to table on /bhp/edit
const new_participant_w_signature_btn = document.getElementById('add_new_bhp_participant_with_signature');
if(new_participant_w_signature_btn) {
    new_participant_w_signature_btn.addEventListener('click', function() {        
        let number_of_rows = participants_table.rows.length;        
        let new_row = participants_table.insertRow(number_of_rows);
        new_row.innerHTML = `
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <input name="participant_name_${number_of_rows}" type="text" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <input name="participant_company_${number_of_rows}" type="text" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <button id="bhp_participant_signature_${number_of_rows}" type="button" class="bg-white py-1 px-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        podpis
                    </button>
                </td>
            </tr>
        `
    });
}


/**
 *  participant signature 
 */ 
import SignaturePad from 'signature_pad';
const canvas = document.getElementById("signature_canvas");
const signature_buttons = document.getElementsByClassName('bhp_participant_signature');
const signature_overlay = document.getElementById("signature_overlay");
const signature_modal = document.getElementById("signature_modal");
const cancel_signature_btn = document.getElementById("cancel_signature");
const save_signature_btn = document.getElementById("save_signature");
let participant_id = 0;
if(canvas) {
    const signaturePad = new SignaturePad(canvas);

    function resizeCanvas() {
        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }        
    window.addEventListener("resize", resizeCanvas);    

    for(let i = 0; i < signature_buttons.length; i++) {
        signature_buttons[i].addEventListener('click', function() {            
            signature_overlay.classList.toggle('hidden');
            signature_overlay.classList.toggle('block');
            signature_modal.classList.toggle('hidden');
            signature_modal.classList.toggle('flex');
            participant_id = this.id.split('_')[3];
            resizeCanvas();            
        });
    }

    // overlay click cancel
    signature_overlay.addEventListener('click', function() {
        signature_overlay.classList.toggle('hidden');
        signature_overlay.classList.toggle('block');
        signature_modal.classList.toggle('hidden');
        signature_modal.classList.toggle('flex');
    });

    // cancel
    cancel_signature_btn.addEventListener('click', function() {
        signature_overlay.classList.toggle('hidden');
        signature_overlay.classList.toggle('block');
        signature_modal.classList.toggle('hidden');
        signature_modal.classList.toggle('flex');
    });

    // save and submit form
    save_signature_btn.addEventListener('click', function() {
        if(!signaturePad.isEmpty()) {
            signature_overlay.classList.toggle('hidden');
            signature_overlay.classList.toggle('block');
            signature_modal.classList.toggle('hidden');
            signature_modal.classList.toggle('flex');            
            let data = signaturePad.toDataURL("image/svg+xml");              
            document.getElementById('participant_id_hidden_input').value = participant_id;
            document.getElementById('signature_hidden_input').value = data;
            document.getElementById('signature_form').submit();            
        }
    });    
}