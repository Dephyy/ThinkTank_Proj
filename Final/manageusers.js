// manageusers.js

document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();
});

async function fetchUsers() {
    try {
        const response = await fetch('fetch_users.php'); // Create this PHP file to fetch users from the database
        const users = await response.json();
        
        const userTableBody = document.getElementById('userTableBody');
        userTableBody.innerHTML = ''; // Clear the table before populating
        
        users.forEach(user => {
            if (user.role !== 'Admin') { // Do not display Admins
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.user_id}</td>
                    <td>${user.email}</td>
                    <td>${user.password}</td>
                    <td>
                        <button onclick="editUser(${user.user_id})">Edit</button>
                        <button onclick="deleteUser(${user.user_id})">Delete</button>
                    </td>
                `;
                userTableBody.appendChild(row);
            }
        });
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

function editUser(userId) {
    // Redirect to an edit user page or implement inline editing
    window.location.href = `edituser.html?id=${userId}`; // You need to create this page
}

async function deleteUser(userId) {
    const confirmation = confirm("Are you sure you want to delete this user?");
    if (confirmation) {
        try {
            await fetch(`delete_user.php?id=${userId}`, { method: 'DELETE' }); // Create this PHP file to handle deletion
            fetchUsers(); // Refresh the user list
        } catch (error) {
            console.error('Error deleting user:', error);
        }
    }
}
