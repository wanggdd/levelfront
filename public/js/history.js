$(function () {

    toggleTab('.tab-item');
    toggleDate('.time-tab-item');



    //  tab content 随动
    function toggleTab(ele) {
        $(ele).on("click", function () {
            const t = $(this);
            const index = t.index();
            t.addClass("active").siblings().removeClass('active');
            $(".list").eq(index).addClass("active").siblings().removeClass("active");
        })
    }
    function toggleDate(ele) {
        $(ele).on("click", function () {
            $(this).addClass("active").siblings().removeClass('active');
        })
    }
    // 显示时间选择器
    var monthArr = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    var yearArr = ['2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'];
    var monthSelect = new MobileSelect({
        trigger: '#show_month',
        wheels: [
            { data: yearArr },
            { data: monthArr },
        ],
        position: [4,2], //初始化定位 打开时默认选中的哪个 如果不填默认为0
        transitionEnd: function (indexArr, data) {
            // 滚动时触发
        },
        callback: function (indexArr, data) {
            console.log(data)
            $("#show_month").text('按月');
            $(".time-year").text(data[0]);
            $(".time-month").text(data[1]);

            //提交php
            $("#form_year").val(data[0]);
            $("#form_month").val(data[1]);
            $("#time_form").submit();
        }
    });

    var yearSelect = new MobileSelect({
        trigger: '#show_year',
        wheels: [
            { data: yearArr }
        ],
        position: [4], //初始化定位 打开时默认选中的哪个 如果不填默认为0
        transitionEnd: function (indexArr, data) {
            // 滚动时触发
        },
        callback: function (indexArr, data) {
            console.log(data)
            $("#show_year").text('按年');
            $(".time-year").text(data[0]);
            $(".time-month").text($('#form_month').val());

            //提交php
            $("#form_year").val(data[0]);
            $("#form_month").val($('#form_month').val());
            $("#time_form").submit();
        }
    });

})