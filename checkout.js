const params = new URLSearchParams(window.location.search);
const plan = params.get("plan");

let price = 0;

if (plan === "monthly") {
    price = 59000;
    document.getElementById("plan-title").innerHTML = "EDUNEXT Premium (Monthly)";
} 
else if (plan === "annual") {
    price = 99000;
    document.getElementById("plan-title").innerHTML = "EDUNEXT Premium (Annual)";
} 
else {
    document.getElementById("plan-title").innerHTML = "Plan Not Found";
}

const rupiah = new Intl.NumberFormat("id-ID");

document.getElementById("plan-price").innerHTML = "Rp " + rupiah.format(price);
document.getElementById("total-payment").innerHTML = "Rp " + rupiah.format(price);
