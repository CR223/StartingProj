function makeDraggable(element) {
    let currentPosX = 0, currentPosY = 0, previousPosX = 0, previousPosY = 0;

    const header = element.querySelector('.window-top');
    const content = element.querySelector('.window-content');

    header.onmousedown = dragMouseDown;

    function dragMouseDown(e) {
        if (e.target.tagName === 'BUTTON') {
            return;
        }

        e.preventDefault();
        previousPosX = e.clientX;
        previousPosY = e.clientY;

        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e.preventDefault();
        currentPosX = previousPosX - e.clientX;
        currentPosY = previousPosY - e.clientY;
        previousPosX = e.clientX;
        previousPosY = e.clientY;

        element.style.top = (element.offsetTop - currentPosY) + 'px';
        element.style.left = (element.offsetLeft - currentPosX) + 'px';
    }

    function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
    }
    const redButton = element.querySelector('.round.red');
    let isContentVisible = true;

    redButton.addEventListener('click', () => {
        isContentVisible = !isContentVisible; 
        content.style.display = isContentVisible ? 'block' : 'none'; 
    });

    makeDraggable(document.querySelector('#myWindow'));
    
}

