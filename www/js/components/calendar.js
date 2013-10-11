$.fn.Calendar = function (onSelect, onChangeMonth) {

    onSelect = onSelect || function () {
    };
	
	onChangeMonth = onChangeMonth || function () {
    };

    var that = this;

    var monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    var today = new Date();
    today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

    this.currentMonth = 0;
    this.currentYear = 0;
    this.currentDate = 0;

    var $btn_left = $(this).find('.arrow-left');
    var $btn_right = $(this).find('.arrow-right');
    var $content = $(this).find('tbody');
    var $header = $(this).find('.calendar-header span');

    var updateMonth = function () {

        var i, j, html = '';
		
		onChangeMonth(new Date(that.currentYear, that.currentMonth, 1));
		this.currentDate = 0;
		onSelect(null);

        $header.text(monthNames[that.currentMonth] + ' ' + that.currentYear);

        var firstDay = new Date(that.currentYear, that.currentMonth, 1).getDay();
        var daysCount = new Date(that.currentYear, that.currentMonth + 1, 0).getDate();

        html += '<tr>';
        for (i = 0; i < (firstDay == 0 ? 7 : firstDay) - 1; i++) {
            html += '<td class="empty"></td>';
        }
        for (j = 1, i = i + 1; i <= 7; i++, j++) {
            html += '<td data-day="' + j  + (j == today.getDate() && that.currentMonth == today.getMonth() && that.currentYear == today.getFullYear() ? 'class="today-cell"' : '') + '"><span>' + j + '</span></td>';
        }
        html += '</tr>';

        for (i = j, j = 1; i <= daysCount; i++, j++) {
            if (j == 1) {
                html += '<tr>';
            }

            html += '<td data-day="' + i + '" ' + (i == today.getDate() && that.currentMonth == today.getMonth() && that.currentYear == today.getFullYear() ? 'class="today-cell"' : '') + '><span>' + i + '</span></td>';

            if (j == 7) {
                html += '</tr>';
                j = 0;
            }
        }

        if (j != 1) {
            for (; j <= 7; j++) {
                html += '<td class="empty"></td>';
            }
            html += '</tr>';
        }

        $content.html(html);


        $content.find('td').not('.empty').on('click', function () {
            that.selectDate(new Date(that.currentYear, that.currentMonth, $(this).data('day')));
        });
    };

    $btn_left.on('click', function () {
        that.currentMonth--;

        if (that.currentMonth < 0) {
            that.currentMonth = 11;
            that.currentYear--;
        }

        updateMonth();

        return false;
    });

    $btn_right.on('click', function () {
        that.currentMonth++;

        if (that.currentMonth > 11) {
            that.currentMonth = 0;
            that.currentYear++;
        }

        updateMonth();

        return false;
    });

    this.selectDate = function (date) {
		
		if(date && (date.getDate() != this.currentDate || date.getMonth() != this.currentMonth || date.getFullYear() != this.currentYear)){   
			this.currentMonth = date.getMonth();
			this.currentYear = date.getFullYear();
			this.currentDate = date.getDate();
			
			$($content.find('td').not('.empty').get(this.currentDate - 1)).addClass('selected');
			
			updateMonth();
			
			$content.find('.day.selected').removeClass('selected');
			$($content.find('td').not('.empty').get(this.currentDate - 1)).addClass('selected');
					
			onSelect(date);
		}
		else{
			this.currentDate = 0;
			$content.find('td').not('.empty').removeClass('selected');
			onSelect(null);
		}

    };

    this.selectDate(today);
    this.selectDate(null);

};