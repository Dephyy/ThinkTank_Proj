document.addEventListener("DOMContentLoaded", () => {
    fetchIdeas();

    // Function to fetch ideas from the database
    function fetchIdeas() {
        fetch('fetch_ideas.php')
            .then(response => response.json())
            .then(data => {
                const ideasTableBody = document.querySelector('#ideas-table tbody');
                ideasTableBody.innerHTML = ''; // Clear the table body
                data.forEach(idea => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td contenteditable="true" data-id="${idea.idea_id}">${idea.title}</td>
                        <td contenteditable="true">${idea.category}</td>
                        <td contenteditable="true">${idea.description}</td>
                        <td>${idea.files_attached}</td>
                        <td>${idea.submitted_by}</td>
                        <td>
                            <button class="save-btn">Save</button>
                            <button class="delete-btn" data-id="${idea.idea_id}">Delete</button>
                        </td>
                    `;
                    ideasTableBody.appendChild(row);
                });

                // Add event listeners for the save and delete buttons
                addEventListeners();
            })
            .catch(error => console.error('Error fetching ideas:', error));
    }

    // Function to add event listeners to save and delete buttons
    function addEventListeners() {
        const saveButtons = document.querySelectorAll('.save-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        saveButtons.forEach(button => {
            button.addEventListener('click', saveIdea);
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', deleteIdea);
        });
    }

    // Function to save edited idea
    function saveIdea(event) {
        const row = event.target.closest('tr');
        const ideaId = row.querySelector('td[data-id]').dataset.id;
        const title = row.querySelector('td[data-id]').innerText;
        const category = row.querySelector('td:nth-child(2)').innerText;
        const description = row.querySelector('td:nth-child(3)').innerText;

        fetch('update_idea.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                idea_id: ideaId,
                title: title,
                category: category,
                description: description
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Idea updated successfully!');
                fetchIdeas(); // Refresh the table
            } else {
                alert('Error updating idea.');
            }
        })
        .catch(error => console.error('Error updating idea:', error));
    }

    // Function to delete an idea
    function deleteIdea(event) {
        const ideaId = event.target.dataset.id;

        if (confirm('Are you sure you want to delete this idea?')) {
            fetch('delete_idea.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ idea_id: ideaId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Idea deleted successfully!');
                    fetchIdeas(); // Refresh the table
                } else {
                    alert('Error deleting idea.');
                }
            })
            .catch(error => console.error('Error deleting idea:', error));
        }
    }
});
