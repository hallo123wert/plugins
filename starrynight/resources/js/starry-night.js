(function () {
    if (window.StarryNight && window.StarryNight.loaded) {
        window.StarryNight.init();
        return;
    }

    var TOTAL_STARS = 400;
    var FLICKER_COUNT = 80;
    var MIN_DISTANCE = 2.5;
    var timer = null;

    function getContainer() {
        var c = document.getElementById('starrynight-stars');
        if (!c) {
            c = document.createElement('div');
            c.id = 'starrynight-stars';
            document.body.appendChild(c);
        }
        return c;
    }

    function init() {
        var container = getContainer();
        if (container.dataset.snReady === '1') return;
        container.dataset.snReady = '1';

        var stars = [];
        var positions = [];
        var fragment = document.createDocumentFragment();

        for (var i = 0; i < TOTAL_STARS; i++) {
            var top, left, tries = 0;
            do {
                top = 5 + Math.random() * 90;
                left = 5 + Math.random() * 90;
                tries++;
            } while (tries < 30 && !farEnough(top, left));

            positions.push({ top: top, left: left });

            var size = 1 + Math.random() * 2;
            var star = document.createElement('div');
            star.className = 'static-star';
            star.style.top = top + '%';
            star.style.left = left + '%';
            star.style.width = size + 'px';
            star.style.height = size + 'px';
            fragment.appendChild(star);
            stars.push(star);
        }
        container.appendChild(fragment);

        function farEnough(t, l) {
            for (var k = 0; k < positions.length; k++) {
                var dx = l - positions[k].left;
                var dy = t - positions[k].top;
                if (Math.sqrt(dx * dx + dy * dy) < MIN_DISTANCE) return false;
            }
            return true;
        }

        function reshuffle() {
            for (var s = 0; s < stars.length; s++) {
                stars[s].className = 'static-star';
            }
            var picked = {};
            var count = 0;
            while (count < FLICKER_COUNT) {
                var idx = Math.floor(Math.random() * stars.length);
                if (picked[idx]) continue;
                picked[idx] = true;
                count++;
                var el = stars[idx];
                el.className = 'flickering-star';
                el.style.animationDelay = (Math.random() * 2).toFixed(1) + 's';
                el.style.animationDuration = (1.5 + Math.random() * 2).toFixed(1) + 's';
            }
        }

        clearInterval(timer);
        reshuffle();
        timer = setInterval(function () {
            if (!container.isConnected) {
                clearInterval(timer);
                return;
            }
            reshuffle();
        }, 3000);
    }

    window.StarryNight = { loaded: true, init: init };

    init();
    document.addEventListener('livewire:navigated', init);
})();
