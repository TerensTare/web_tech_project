
// data

const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

const SPEED = 60;

const WIDTH = canvas.width;
const HEIGHT = canvas.height - 50;
const GRID_SIZE = 8;
const CELL_COUNT = GRID_SIZE - 1;
const CELL_SIZE = WIDTH / GRID_SIZE;

// game state

const boxes = new Array(CELL_COUNT);

const BoxSides = {
    BOTTOM: 0,
    LEFT: 1,
    RIGHT: 2,
    TOP: 3,
};

const Colors = {
    CLEAR: '#FFC896',
    DOTS: '#123456',
    PLAYER_1: '#FF0064',
    PLAYER_2: '#0096FF',
};

let p1_turn = true;

// functions

const vec = function (x, y) { x: x, y; y; };

function side() {
    return {
        owner: undefined,
        selected: false,
    };
}

const box = (x, y, size) => ({
    x: x,
    y: y,
    w: size,
    h: size,
    top: y,
    left: x,
    bottom: y + size,
    right: x + size,
    hl: undefined,
    sides: {
        top: side(),
        left: side(),
        bottom: side(),
        right: side(),
    },

    isMouseInside: (x, y) => {
        return x >= this.left && x < this.right
            && y >= this.top && y < this.bottom;
    },

    highlightSide: (x, y) => {
        const d = {
            top: y - this.top,
            left: x - this.left,
            bottom: this.bottom - y,
            right: this.right - x,
        };

        const minDst = Math.min(d.top, d.left, d.bottom, d.right);

        let hl_side = undefined;
        if (minDst == d.top && !this.sides.top.selected)
            hl_side = BoxSides.TOP;
        else if (minDst == d.left && !this.sides.left.selected)
            hl_side = BoxSides.LEFT;
        else if (minDst == d.right && !this.sides.right.selected)
            hl_side = BoxSides.RIGHT;
        else if (!this.sides.bottom.selected)
            hl_side = BoxSides.BOTTOM;

        if (hl_side !== undefined)
            this.hl = hl_side;

        return this.hl;
    },
    drawBoxSide: (side, color) => {
        switch (side) {
            case BoxSides.BOTTOM:
                drawLine(this.left, this.bottom, this.right, this.bottom, color);
                break;

            case BoxSides.LEFT:
                drawLine(this.left, this.top, this.left, this.bottom, color);
                break;

            case BoxSides.RIGHT:
                drawLine(this.right, this.top, this.right, this.bottom, color);
                break;

            case BoxSides.TOP:
                drawLine(this.left, this.top, this.right, this.top, color);
                break;
        }
    },
    drawBoxSides: () => {
        const drawBoxSide = (side, color) => {
            switch (side) {
                case BoxSides.BOTTOM:
                    drawLine(this.left, this.bottom, this.right, this.bottom, color);
                    break;

                case BoxSides.LEFT:
                    drawLine(this.left, this.top, this.left, this.bottom, color);
                    break;

                case BoxSides.RIGHT:
                    drawLine(this.right, this.top, this.right, this.bottom, color);
                    break;

                case BoxSides.TOP:
                    drawLine(this.left, this.top, this.right, this.top, color);
                    break;
            }
        };

        if (this.hl !== null)
            drawBoxSide(this.hl, p1_turn ? Colors.PLAYER_1 : Colors.PLAYER_2);
    },
});

// rendering

function render() {
    clearScreen();

    drawBoxes();
    drawDots();
}

function clearScreen() {
    ctx.fillStyle = Colors.CLEAR;
    ctx.fillRect(0, 0, WIDTH, HEIGHT);
}

function drawDots() {
    for (let j = 0; j < CELL_COUNT; ++j) {
        const y = CELL_SIZE * (j + 1);
        for (let i = 0; i < CELL_COUNT; ++i) {
            drawCircle(CELL_SIZE * (i + 1), y);
        }
    }
}

function drawBoxes() {
    for (let j = 0; j < CELL_COUNT; ++j) {
        for (let i = 0; i < CELL_COUNT; ++i) {
            boxes[j][i].drawBoxSides();
        }
    }
}

function drawLine(x1, y1, x2, y2, color) {
    ctx.beginPath();
    ctx.strokeStyle = color;
    ctx.lineWidth = CELL_SIZE / 12;
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.stroke();
    ctx.closePath();
}

function drawCircle(x, y) {
    ctx.beginPath();
    ctx.fillStyle = Colors.DOTS;
    ctx.arc(x, y, CELL_SIZE / 10, 0, 2 * Math.PI);
    ctx.fill();
    ctx.closePath();
}

// turn-related data

function show_current_turn() {

}

function highlightSide(x, y) {
    for (let j = 0; j < CELL_COUNT; ++j) {
        for (let i = 0; i < CELL_COUNT; ++i) {
            if (boxes[j][i].isMouseInside(x, y)) {
                const hl_side = boxes[j][i].highlightSide(x, y);
            }
        }
    }

}

// event handlers

function handleInput() {
    canvas.addEventListener('mousemove', handleMouseMove);
}

function handleMouseMove(e) {
    const x = e.clientX;
    const y = e.clientY;

    highlightSide(x, y);
}

// game logic

function setup() {
    p1_turn = Math.random() > 0.5;

    for (let j = 0; j < CELL_COUNT; ++j) {
        boxes[j] = new Array(CELL_COUNT);
        for (let i = 0; i < CELL_COUNT; ++i) {
            boxes[j][i] = box(CELL_SIZE * (i + 1),
                CELL_SIZE * (j + 1),
                CELL_SIZE
            );
        }
    }
}

function loop() {
    render();

    setTimeout(loop, 1000 / SPEED);
}

function run() {
    setup();

    handleInput();

    loop();
}

run();