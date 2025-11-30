<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Medicine Inventory CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: default;
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
    <h2>Medicine Inventory Management</h2>
</header>

<main class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <input type="text" id="searchInput" class="form-control search-box me-3" placeholder="Search medicine by name..." onkeyup="renderMedicineList()">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#medicineModal" onclick="openMedicineModal('create')">
            <i class="fas fa-plus"></i> Add New Medicine
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Expiry Date</th>
                    <th>Dosage Instruction</th>
                    <th>Unit Price (RM)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="medicineTableBody">
                </tbody>
        </table>
    </div>

</main>

<div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="medicineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="medicineModalLabel">Add/Edit Medicine</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="medicineForm">
                    <input type="hidden" id="medicineId"> 

                    <div class="mb-3">
                        <label for="name" class="form-label">Medicine Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" id="stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiryDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="dosage" class="form-label">Dosage Instruction</label>
                        <input type="text" class="form-control" id="dosage" placeholder="e.g., 1 tablet 3 times a day" required>
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price (RM)</label>
                        <input type="number" step="0.01" class="form-control" id="unitPrice" required min="0.01">
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="formSubmitButton">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // 1. Data Store (Simulated Database)
    let medicineInventory = [
        { id: 1, name: 'Aspirin', stock: 150, expiryDate: '2025-10-01', dosage: 'One tablet daily', unitPrice: 0.50 },
        { id: 2, name: 'Paracetamol', stock: 30, expiryDate: '2026-05-15', dosage: 'One or two tablets every 4-6 hours', unitPrice: 0.25 },
        { id: 3, name: 'Ibuprofen', stock: 5, expiryDate: '2024-12-31', dosage: 'One capsule every 8 hours', unitPrice: 1.20 },
        { id: 4, name: 'Amoxicillin', stock: 0, expiryDate: '2025-11-20', dosage: '250mg 3 times a day', unitPrice: 2.50 },
    ];
    let nextId = 5; // To assign unique IDs for new items

    // 2. Read Function: Renders the table based on the current inventory and search term
    function renderMedicineList() {
        const tableBody = document.getElementById('medicineTableBody');
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


            html += `
                <tr>
                    <td>${medicine.name}</td>
                    <td>
                        <span class="badge ${stockBadgeClass} status-badge-stock">${stockText} (${medicine.stock})</span>
                    </td>
                    <td>${medicine.expiryDate}</td>
                    <td>${medicine.dosage}</td>
                    <td>${formattedPrice}</td>
                    <td>
                        <button class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#medicineModal" onclick="openMedicineModal('update', ${medicine.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteMedicine(${medicine.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    }

    // 3. Create/Update Function: Handles form submission
    document.getElementById('medicineForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const id = parseInt(document.getElementById('medicineId').value);
        const name = document.getElementById('name').value.trim();
        const stock = parseInt(document.getElementById('stock').value);
        const expiryDate = document.getElementById('expiryDate').value;
        const dosage = document.getElementById('dosage').value.trim();
        const unitPrice = parseFloat(document.getElementById('unitPrice').value);

        const newMedicineData = { name, stock, expiryDate, dosage, unitPrice };

        if (id) {
            // Update (U) operation
            updateMedicine(id, newMedicineData);
        } else {
            // Create (C) operation
            insertMedicine(newMedicineData);
        }

        // Close the modal after submission
        const modalElement = document.getElementById('medicineModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();

        // Re-render the list to show changes
        renderMedicineList();
    });

    // Sub-function for Create (Insert)
    function insertMedicine(data) {
        data.id = nextId++; // Assign new unique ID
        medicineInventory.push(data);
        console.log('Medicine Added:', data);
    }

    // Sub-function for Update
    function updateMedicine(id, data) {
        const index = medicineInventory.findIndex(m => m.id === id);
        if (index !== -1) {
            medicineInventory[index] = { id, ...data }; // Preserve the ID
            console.log('Medicine Updated:', medicineInventory[index]);
        }
    }
    
    // 4. Delete Function (D)
    function deleteMedicine(id) {
        if (confirm('Are you sure you want to delete this medicine?')) {
            medicineInventory = medicineInventory.filter(m => m.id !== id);
            console.log('Medicine Deleted. New Inventory:', medicineInventory);
            renderMedicineList(); // Re-render the list immediately
        }
    }

    // Utility function to set up the modal for Create or Update
    function openMedicineModal(mode, id = null) {
        const modalLabel = document.getElementById('medicineModalLabel');
        const form = document.getElementById('medicineForm');
        const submitButton = document.getElementById('formSubmitButton');

        // Reset the form and hidden ID first
        form.reset();
        document.getElementById('medicineId').value = ''; 
        
        if (mode === 'create') {
            modalLabel.textContent = 'Add New Medicine';
            submitButton.textContent = 'Add Medicine';
        } else if (mode === 'update' && id !== null) {
            modalLabel.textContent = 'Edit Medicine';
            submitButton.textContent = 'Save Changes';
            
            // Find the medicine object
            const medicine = medicineInventory.find(m => m.id === id);

            if (medicine) {
                // Populate the form fields for editing
                document.getElementById('medicineId').value = medicine.id;
                document.getElementById('name').value = medicine.name;
                document.getElementById('stock').value = medicine.stock;
                document.getElementById('expiryDate').value = medicine.expiryDate;
                document.getElementById('dosage').value = medicine.dosage;
                document.getElementById('unitPrice').value = medicine.unitPrice;
            }
        }
    }

    // Initial render when the page loads
    document.addEventListener('DOMContentLoaded', renderMedicineList);
</script>

</body>
</html>