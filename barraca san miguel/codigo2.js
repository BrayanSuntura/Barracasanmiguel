function generatePDF() {
    const { jsPDF } = window.jspdf;

    // Get form data
    const customerName = document.getElementById('customerName').value;
    const woodQuantity = document.getElementById('woodQuantity').value;
    const squareMeters = document.getElementById('squareMeters').value;
    const totalCost = document.getElementById('totalCost').value;
    const email = document.getElementById('email').value;

    // Create PDF
    const doc = new jsPDF();
    doc.text(`Customer Name: ${customerName}`, 10, 10);
    doc.text(`Quantity of Wood: ${woodQuantity} cubic meters`, 10, 20);
    doc.text(`Square Meters: ${squareMeters}`, 10, 30);
    doc.text(`Total Cost: USD ${totalCost}`, 10, 40);
    doc.text(`Email: ${email}`, 10, 50);

    // Save PDF
    doc.save('Reservation.pdf');
}

