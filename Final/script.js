document.addEventListener('DOMContentLoaded', function() {
    fetchUsers();

    function fetchUsers() {
        fetch('fetch_users.php')
            .then(response => response.json())
            .then(data => {
                const userTableBody = document.getElementById('userTableBody');
                userTableBody.innerHTML = ''; // Clear existing entries
                data.forEach(user => {
                    userTableBody.innerHTML += `
                        <tr>
                            <td>${user.user_id}</td>
                            <td>
                                <span id="username-${user.user_id}">${user.username}</span>
                                <input type="text" id="edit-username-${user.user_id}" value="${user.username}" style="display:none;">
                            </td>
                            <td>
                                <span id="email-${user.user_id}">${user.email}</span>
                                <input type="email" id="edit-email-${user.user_id}" value="${user.email}" style="display:none;">
                            </td>
                            <td>
                                <span id="password-${user.user_id}">******</span>
                                <input type="password" id="edit-password-${user.user_id}" placeholder="New Password" style="display:none;">
                            </td>
                            <td>
                                <span id="role-${user.user_id}">${user.role}</span>
                                <select id="edit-role-${user.user_id}" style="display:none;">
                                    <option value="User" ${user.role === 'User' ? 'selected' : ''}>User</option>
                                    <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Admin</option>
                                </select>
                            </td>
                            <td>
                                <button onclick="toggleEdit(${user.user_id})">Edit</button>
                                <button onclick="deleteUser(${user.user_id})">Delete</button>
                                <button id="save-${user.user_id}" onclick="saveUser(${user.user_id})" style="display:none;">Save</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    window.toggleEdit = function(userId) {
        const usernameSpan = document.getElementById(`username-${userId}`);
        const emailSpan = document.getElementById(`email-${userId}`);
        const passwordSpan = document.getElementById(`password-${userId}`);
        const roleSpan = document.getElementById(`role-${userId}`);
        
        const usernameInput = document.getElementById(`edit-username-${userId}`);
        const emailInput = document.getElementById(`edit-email-${userId}`);
        const passwordInput = document.getElementById(`edit-password-${userId}`);
        const roleSelect = document.getElementById(`edit-role-${userId}`);
        const saveButton = document.getElementById(`save-${userId}`);

        const isEditing = usernameInput.style.display === 'block';

        // Toggle between edit and view modes
        usernameSpan.style.display = isEditing ? 'block' : 'none';
        emailSpan.style.display = isEditing ? 'block' : 'none';
        passwordSpan.style.display = isEditing ? 'block' : 'none';
        roleSpan.style.display = isEditing ? 'block' : 'none';

        usernameInput.style.display = isEditing ? 'none' : 'block';
        emailInput.style.display = isEditing ? 'none' : 'block';
        passwordInput.style.display = isEditing ? 'none' : 'block';
        roleSelect.style.display = isEditing ? 'none' : 'block';
        saveButton.style.display = isEditing ? 'none' : 'inline-block';
    };

    window.saveUser = function(userId) {
        const username = document.getElementById(`edit-username-${userId}`).value;
        const email = document.getElementById(`edit-email-${userId}`).value;
        const password = document.getElementById(`edit-password-${userId}`).value; // Password can be empty
        const role = document.getElementById(`edit-role-${userId}`).value;
    
        fetch(`update_user.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                userId: userId,
                username: username,
                email: email,
                password: password, // Send empty string if password is unchanged
                role: role
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User updated successfully!');
                fetchUsers(); // Refresh user list after update
            } else {
                alert('Error updating user: ' + data.message);
            }
        });
    };
    

    window.deleteUser = function(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`delete_user.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: userId }) // Send the user ID in the body
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchUsers(); // Refresh user list after deletion
                } else {
                    console.error('Error deleting user:', data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
        }
    };
});


