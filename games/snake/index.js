
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

const TILE_COUNT = 20;
const TILE_SIZE = canvas.width / TILE_COUNT;

let speed = 5;

const snake = {
    head: {
        x: 10,
        y: 10,
    },
    body: [],
    direction: {
        x: 0,
        y: 0,
    },
    speed: 5,
};

const food = {
    x: 5,
    y: 5,
};

function run() {
    document.addEventListener('keydown', key_down);

    render();
}

function render() {
    clear();

    moveSnake();
    if (isGameOver()) {
        ctx.fillStyle = 'white';
        ctx.font = '50px Arial';
        ctx.fillText('Game Over', canvas.width / 2 - 150, canvas.height / 2);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                snake.head.x = 10;
                snake.head.y = 10;
                snake.body = [];
                snake.direction.x = 0;
                snake.direction.y = 0;
                food.x = 5;
                food.y = 5;
                render();
            }
        }, { once: true });
        return;
    }
    checkIfEating();

    draw();

    setTimeout(render, 1000 / speed);
}

function clear() {
    ctx.fillStyle = 'black';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function draw() {
    drawSnake();
    drawFood();
    drawScore();
}

function drawSnake() {
    ctx.fillStyle = 'orange';
    ctx.fillRect(snake.head.x * TILE_SIZE, snake.head.y * TILE_SIZE, TILE_SIZE, TILE_SIZE);

    ctx.fillStyle = 'green';
    for (let i = 0; i < snake.body.length; ++i) {
        ctx.fillRect(snake.body[i].x * TILE_SIZE, snake.body[i].y * TILE_SIZE, TILE_SIZE, TILE_SIZE);
    }
}

function moveSnake() {
    snake.body.push({
        x: snake.head.x,
        y: snake.head.y,
    });

    snake.body.shift();

    snake.head.x += snake.direction.x;
    snake.head.y += snake.direction.y;

    if (snake.head.x < 0) {
        snake.head.x = TILE_COUNT - 1;
    }
    if (snake.head.x > TILE_COUNT - 1) {
        snake.head.x = 0;
    }
    if (snake.head.y < 0) {
        snake.head.y = TILE_COUNT - 1;
    }
    if (snake.head.y > TILE_COUNT) {
        snake.head.y = 0;
    }
}

function checkIfEating() {
    if (snake.head.x === food.x && snake.head.y === food.y) {
        food.x = Math.floor(Math.random() * TILE_COUNT);
        food.y = Math.floor(Math.random() * TILE_COUNT);

        snake.body.push({
            x: snake.head.x,
            y: snake.head.y,
        });
    }
}

function drawFood() {
    ctx.fillStyle = 'red';
    ctx.fillRect(food.x * TILE_SIZE, food.y * TILE_SIZE, TILE_SIZE, TILE_SIZE);
}

function drawScore() {
    ctx.fillStyle = 'white';
    ctx.font = '20px Arial';
    ctx.fillText('Score: ' + snake.body.length, 10, 30);
}

function isGameOver() {
    for (let i = 0; i < snake.body.length; ++i) {
        if (snake.body[i].x === snake.head.x && snake.body[i].y === snake.head.y) {
            return true;
        }
    }
    return false;
}

function key_down(e) {
    switch (e.key) {
        case 'ArrowUp':
            if (snake.direction.y === 1) {
                return;
            }
            snake.direction.x = 0;
            snake.direction.y = -1;
            break;
        case 'ArrowDown':
            if (snake.direction.y === -1) {
                return;
            }
            snake.direction.x = 0;
            snake.direction.y = 1;
            break;
        case 'ArrowLeft':
            if (snake.direction.x === 1) {
                return;
            }
            snake.direction.x = -1;
            snake.direction.y = 0;
            break;
        case 'ArrowRight':
            if (snake.direction.x === -1) {
                return;
            }
            snake.direction.x = 1;
            snake.direction.y = 0;
            break;
    }
}

run();