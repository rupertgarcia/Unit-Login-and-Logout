document.getElementById("idNumber").addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9]/g, ""); // Only allows digits for ID Number
});

document.getElementById("localNumber").addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9]/g, ""); // Only allows digits for Local Number
});
