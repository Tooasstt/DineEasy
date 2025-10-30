// let total = 0;
// let points = 0;
// const orderTable = document.querySelector("#order-table tbody");
// const totalDisplay = document.querySelector("#total");
// const pointsDisplay = document.querySelector("#points");

// document.querySelectorAll(".add-btn").forEach(btn => {
//   btn.addEventListener("click", () => {
//     const item = btn.parentElement;
//     const name = item.dataset.name;
//     const price = parseFloat(item.dataset.price);

//     const row = document.createElement("tr");
//     row.innerHTML = `
//       <td>${name}</td>
//       <td>₱${price}</td>
//       <td><button class="remove-btn">Remove</button></td>
//     `;
//     orderTable.appendChild(row);
//     total += price;
//     totalDisplay.textContent = total;
//   });
// });

// orderTable.addEventListener("click", (e) => {
//   if (e.target.classList.contains("remove-btn")) {
//     const row = e.target.closest("tr");
//     const price = parseFloat(row.children[1].textContent.replace('₱',''));
//     total -= price;
//     totalDisplay.textContent = total;
//     row.remove();
//   }
// });

// document.querySelector("#generate-qr").addEventListener("click", () => {
//   alert("✅ QR generated! Scan at kiosk to confirm your order.");
//   points += 10; // sample logic for earning points
//   pointsDisplay.textContent = points;
// });
