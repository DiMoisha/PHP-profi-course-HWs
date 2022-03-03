var Calc = {
    form: 'calc',
    lang: { error: 'Ошибка' },
    calc: function () {
        var f = document.forms.calc;
        if (f) {
            var k = this.getK();
            var res = f.w.value * f.l.value * f.h.value * k;
            if (isNaN(res)) {
                this.setRes(this.lang.error);
                return;
            }
            this.setRes(this.formatPrice(res.toFixed(0)));
        }
    },
    validateTfFloat: function (tf) {
        var v = tf.value.replace(/\,/g, '.').replace(/[^\d\.]/g, '');
        if (isNaN(parseFloat(v))) {
            tf.className = 'calc-tf-invalid';
            return false;
        }
        tf.value = v;
        tf.className = 'calc-tf';
        return true;
    },
    tfChanged: function (tf) {
        if (false == this.validateTfFloat(tf)) {
            this.setRes(this.lang.error);
            return;
        }
        this.calc();
    },
    setRes: function (html) {
        var e = document.getElementById('calc-res');
        if (e) e.innerHTML = html;
    },
    formatPrice: function (str) {
        if (str.length >= 4) {
            var parts = str.split("\."), res = [];
            for (var i = (parts[0].length - 1), j = 1; i >= 0; --i, ++j) {
                res.unshift(parts[0].charAt(i));
                if (j % 3 == 0)
                    res.unshift(',');
            }
            return '<b>'+res.join('') + (parts[1] ? '\.' + parts[1] : '') + ' тонн</b>';
        }
        return '<b>'+str + ' кг</b>';
    },
    changeType: function (sel) {
        var i = sel.selectedIndex;
        if (i < 0) i = 0;
        this.calc();
    },
    getK: function () {
        var sel = document.getElementById('calc-asphalt-sel');
        var k = 0;
        if (sel) {
            var i = sel.selectedIndex;

            switch (i) {
                case 0:
                case 8:
                    k = 23.6;
                    break;

                case 1:
                case 2:
                case 3:
                    k = 24;
                    break;

                case 4:
                case 11:
                    k = 23.8;
                    break;

                case 5:
                case 9:
                case 10:
                    k = 23.5;
                    break;

                case 6:
                    k = 23.3;
                    break;

                case 7:
                    k = 22.4;
                    break;

                case 12:
                    k = 25.9;
                    break;

                default:
                    k = 0;
            }

        }

        return k;
    }
};