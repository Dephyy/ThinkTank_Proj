document.getElementById('login-form').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent default form submission

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('thinktank.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (data.success) {
            // Redirect based on user role
            window.location.href = data.redirect; // Redirect to admin-dashboard.html or home.html
        } else {
            alert(data.message); // Display error message
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    }
});
//ADMIN DASHBOARD
// Function to fetch users from the server
function fetchUsers() {
    fetch('fetch-users.php')
        .then(response => response.json())
        .then(data => {
            const userTableBody = document.getElementById('userTableBody');
            userTableBody.innerHTML = ''; // Clear existing rows

            if (data.length === 0) {
                userTableBody.innerHTML = '<tr><td colspan="5">No users found.</td></tr>';
            } else {
                data.forEach(user => {
                    userTableBody.innerHTML += `
                        <tr>
                            <td>${user.user_id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button onclick='editUser(${user.user_id})'>Edit</button>
                                <button onclick='deleteUser(${user.user_id})'>Delete</button>
                            </td>
                        </tr>`;
                });
            }
        })
        .catch(error => console.error('Error fetching users:', error));
}

// Call fetchUsers on page load
window.onload = fetchUsers;

// Function to edit user
function editUser(userId) {
    alert('Edit user with ID: ' + userId);
    // Implement editing functionality here
}

// Function to delete user
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Make a request to delete the user
        fetch(`delete-user.php?user_id=${userId}`, { method: 'DELETE' })
            .then(response => {
                if (response.ok) {
                    alert('User deleted successfully.');
                    fetchUsers(); // Refresh the user list
                } else {
                    alert('Error deleting user.');
                }
            })
            .catch(error => console.error('Error deleting user:', error));
    }
}

