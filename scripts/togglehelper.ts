function isUnSavedChange(): boolean {
    let checkboxes = document.querySelectorAll(".switch") as NodeListOf<HTMLInputElement>;
    for (let i = 0; i < checkboxes.length; i++) {
        let checkbox = checkboxes[i];
        if (checkbox.classList.contains("changed")) {
            return true;
        }
    }
    return false;
}
window.addEventListener("DOMContentLoaded", () => {
    let checkboxes = document.querySelectorAll(".switch") as NodeListOf<HTMLInputElement>;
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", (e) => {
            let element = e.currentTarget as HTMLInputElement;
            element.classList.toggle("changed");
        });
    });
});
/*window.onbeforeunload = (e) => {
    if (isUnSavedChange()) {
        let confirmationMessage = "You have unsaved changes. Are you sure you want to leave?";
        (e || window.event).returnValue = confirmationMessage; // For most browsers
        return confirmationMessage; // For some older browsers
    }
};*/