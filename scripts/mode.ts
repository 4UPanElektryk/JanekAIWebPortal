window.addEventListener("DOMContentLoaded", () => {
	let ionicons = document.createElement("script");
	ionicons.src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js";
	ionicons.setAttribute("type", "module");
	document.head.appendChild(ionicons);
	ionicons = document.createElement("script");
	ionicons.src = "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js";
	ionicons.setAttribute("nomodule", "");
	document.head.appendChild(ionicons);

	const modebutton = document.getElementById("button-mode");

	if (modebutton) {
		modebutton.addEventListener("click", () => {
			const body = document.body;
			body.classList.toggle("dark");
			body.classList.toggle("light");
			const currentMode = body.classList.contains("dark") ? "dark" : "light";
			localStorage.setItem("mode", currentMode);
		});
	}
	
	if (localStorage.getItem("mode")) {
		const currentMode = localStorage.getItem("mode");
		const body = document.body;
		if (currentMode === "dark") {
			body.classList.add("dark");
			body.classList.remove("light");
		} else {
			body.classList.add("light");
			body.classList.remove("dark");
		}
	}
});