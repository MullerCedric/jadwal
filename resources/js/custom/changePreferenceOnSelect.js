export default function () {
    const nameSelect = document.getElementById('redirectSelector');
    if (nameSelect) {
        nameSelect.addEventListener('change', redirectOnSelect, false);
    }
}

function redirectOnSelect(e) {
    window.location = route('preferences.show', {preference: e.target.value});
}
