function show_value(slider_id) {
        let x = document.getElementById(slider_id).value;
        document.getElementById("selected_" + slider_id).innerHTML = x;
}
function add_one(slider_id, scale = 1) {
        let el = document.getElementById(slider_id);
        el.value = parseFloat(el.value) + (1 * scale);
        show_value(slider_id);
}
function subtract_one(slider_id, scale = 1) {
        let el = document.getElementById(slider_id);
        el.value = parseFloat(el.value) - (1 * scale);
        show_value(slider_id);
}
