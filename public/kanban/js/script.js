let listId = 0;

function addCard(listId) {
    const list = document.getElementById(listId);
    const card = document.createElement('div');
    card.className = 'card';
    card.innerHTML = '<input type="text" placeholder="Enter card title">';
    list.appendChild(card);
}

function addList() {
    const board = document.querySelector('.board');
    const currentListId = ++listId;
    const column = document.createElement('div');
    column.className = 'column';
    column.innerHTML = `
        <header>New List</header>
        <div id="list-${currentListId}" class="cards"></div>
        <div class="add-card-button" onclick="addCard('list-${currentListId}')">+ Add a card</div>
    `;
    board.appendChild(column);
}

