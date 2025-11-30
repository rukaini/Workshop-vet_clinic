<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Medicine Inventory List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .search-box {
            max-width: 400px;
        }
        .status-badge-stock {
            min-width: 70px;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>

<header class="p-3 bg-primary text-white text-center">
    <h2>Medicine List and Stock View</h2>
</header>

<main class="container py-5">

    <input type="text" id="searchInput" class="form-control search-box mb-4" placeholder="Search medicine by name..." onkeyup="renderMedicineList()">

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Expiry Date</th>
                    <th>Dosage Instruction</th>
                    <th>Unit Price (RM)</th>
                </tr>
            </thead>
            <tbody id="medicineTableBody">
                </tbody>
        </table>
    </div>

</main>

<script>
    // 1. Data Store (Same as the previous inventory)
    let medicineInventory = [
        { id: 1, name: 'Aspirin', stock: 150, expiryDate: '2025-10-01', dosage: 'One tablet daily', unitPrice: 0.50 },
        { id: 2, name: 'Paracetamol', stock: 30, expiryDate: '2026-05-15', dosage: 'One or two tablets every 4-6 hours', unitPrice: 0.25 },
        { id: 3, name: 'Ibuprofen', stock: 5, expiryDate: '2024-12-31', dosage: 'One capsule every 8 hours', unitPrice: 1.20 },
        { id: 4, name: 'Amoxicillin', stock: 0, expiryDate: '2025-11-20', dosage: '250mg 3 times a day', unitPrice: 2.50 },
        { id: 5, name: 'Lisinopril', stock: 85, expiryDate: '2027-02-10', dosage: '5mg once daily', unitPrice: 3.15 },
        { id: 6, name: 'Metformin', stock: 12, expiryDate: '2024-11-05', dosage: '500mg twice daily with meals', unitPrice: 0.80 }
    ];

    // 2. Read Function: Renders the table based on the current inventory and search term
    function renderMedicineList() {
        const tableBody = document.getElementById('medicineTableBody');
        // Get search input and convert to lower case for comparison
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        let html = '';

        // Filter the inventory based on the search input
        const filteredInventory = medicineInventory.filter(medicine => 
            medicine.name.toLowerCase().includes(searchInput)
        );

        filteredInventory.forEach(medicine => {
            // Determine stock status for badge
            let stockBadgeClass = '';
            let stockText = '';

            if (medicine.stock > 50) {
                stockBadgeClass = 'bg-success';
                stockText = 'High Stock';
            } else if (medicine.stock > 0) {
                stockBadgeClass = 'bg-warning text-dark';
                stockText = 'Low Stock';
            } else {
                stockBadgeClass = 'bg-danger';
                stockText = 'Out of Stock';
            }
            
            // Format unit price to two decimal places
            const formattedPrice = parseFloat(medicine.unitPrice).toFixed(2);

            // Create the table row (TR) without any action buttons
            html += `
                <tr>
                    <td>${medicine.name}</td>
                    <td>
                        <span class="badge ${stockBadgeClass} status-badge-stock">${stockText} (${medicine.stock})</span>
                    </td>
                    <td>${medicine.expiryDate}</td>
                    <td>${medicine.dosage}</td>
                    <td>${formattedPrice}</td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    }

    // Initial render when the page loads
    document.addEventListener('DOMContentLoaded', renderMedicineList);
</script>

</body>
</html>