/**
 * Скрипты для работы со страницей Доска проекта
 *
 * Сперва загружается пустая страница, потом дергается функция забора инфы по api
 * после того как придут данные происходит динамическая отрисовка колонок и их карточек.
 * В момент создания колонки, на кнопки взаимодействия вешаются события CRUD - create, read, update, delete.
 * По этой аналогии после создания текущей колонки идет отрисовка ее карточек. Так же после создания карточки
 * вешается на ее кнопки взаимодействия необходимые события.
 *
 */
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // глобальный объект данных проекта
    // используется для генерации в окне изменения ползиции колонки, генерация option в <select>
    // далее возможно использовать этот блок для перевода всей страницы на ajax запросы без перезагрузки стрницы
    window.project_instance = '';


    /**
     * Работа с колонками
     */

    // много где используется данный параметр, вынес для удобства
    let current_project_id = $('#current_project_id').data("project_id");

    /**
     * Изменение колонки
     */
    function edit_column(el) {
        let column_id    = el.data("column_id");
        let column_sort_number  = el.data("column_sort_number");
        let column_state = el.data("column_state");
        let column_type = el.data("column_type");
        let column_name = el.data("column_name");
        let column_description =el.data("column_description");

        // отчистка данных
        $("#UpdateColumnId").val('');
        $("#UpdateColumnName").val('');
        $("#UpdateColumnSortNumberSelect").find('option').remove();
        $("#UpdateColumnType").find("input[data-column_type_edit]").removeAttr("checked");
        $("#UpdateColumnState").find("input[data-column_state_edit]").removeAttr("checked");

        // добавляем данные
        $("#UpdateColumnId").val(column_id);
        $("#UpdateColumnName").val(column_name);
        // добавляем в <select> список всех колонок и показываем текущую колонку в нем как выбранную
        let list_columns = window.project_instance['columns'];
        $.each(list_columns.reverse(), function (index, value) {
            let option = new Option(value["name"], value["column_sort_number"]);
            // указываем текущую колонку
            if(el.data("column_sort_number") === value["column_sort_number"]){
                option.selected = true;
            }
            $("#UpdateColumnSortNumberSelect").append(option);
        });

        $("#UpdateColumnType").find("input[data-column_type_edit='"+column_type+"']").attr("checked", true);
        $("#UpdateColumnState").find("input[data-column_state_edit='"+column_state+"']").attr("checked", true);

        if(column_description) {
            $("#UpdateColumnDescription").val(column_description);
        }
    }

    /**
     * Обновления связи карточки с закрепленной за ней колонкой
     * {
     * project_id: <project_id>
     * sender_id:  <column_id>
     * receiver_id:<column_id>
     * card:       <card_id>
     * }
     * @return {boolean}
     */
    function UpdateCardSorting(item) {
        let dataObject = {};
        let receiver_id = $(item["item"][0]).parent().parent().data("column_id"); // куда перемещено
        let card = $(item["item"][0]).data("card_id"); // карточка
        let list_sorting = $(item["item"][0]).parent().parent().find(".card.dashboard-card-container");

        if( item["sender"] ) {
            return false; // убираем артефактное событие
        }
        // перемещение между карточками внутри одной колонки
        else{
            let cards = [];
            $.each(list_sorting, function(index, value){
                cards[index] = $(value).data("card_id");
            });
            dataObject = {
                project_id: current_project_id,
                receiver_id: receiver_id,
                cards: cards,
            };
        }

        let post = $.post( "/api/dashboard/card/position", dataObject );
        post.done(function( data ) {
            $(document).Toasts('create', {
                title: 'Карточка',
                autohide: true,
                delay: 2500,
                body: data,
            });
        });
    }

    /**
     * Дополнение данными всплывающую форму
     */
    function add_card(parent) {
        $("div#modal-add-card").find("input[name='column_id']").val("");
        let column_id = parent.data("column_id");
        $("div#modal-add-card").find("input[name='column_id']").val(column_id)
    }



    /**
     * Изменение карточки
     * Наполнение карточки данными для редактирования
     */
    function update_card(element) {
        let form_update = $("div#modal-fix-card");
        // отчищаем данные с формы
        form_update.find("input[name='card_name']").val("");
        form_update.find("input[name='card_id']").val("");
        form_update.find("input[name='description']").val("");
        form_update.find("input[name='finish_time']").val("");
        form_update.find("input[name='card_type']").removeAttr("checked");

        // добавляем данные текущей карточки
        form_update.find("input[name='card_name']").val(element.data("card_name"));
        form_update.find("input[name='card_id']").val(element.data("card_id"));
        form_update.find("textarea[name='description']").val(element.data("card_description"));
        form_update.find("input[name='finish_time']").val(element.data("card_finish_time"));
        form_update.find("input[data-card_type_int='"+element.data("card_type")+"']").attr('checked', true);

        //если есть список тасков инициируем показ тасков
        get_check_list("#modal-fix-card");
        save_check_list("div#modal-fix-card");

        //добавляем обработчик кнопки добавление таск листа
        add_event_on_button_add_task()
    }

    /**
     * Отображение карточек колонки
     */
    function show_cards(column, cards) {
        $.each(cards, function(index, value){
            // клонируем шаблон и вставляем в поле содержания карточек в колонке созданный элемент карточки
            // наделяем созданный элемент параметрами для корректного изменения данных карточки
            let card = $( "#clone_card")
                .clone()
                .appendTo(column.find("div.connectedSortable.ui-sortable"))
                .removeAttr("id")
                .removeClass("card-example")
                .attr("data-column_id",        value["id_column"])
                .attr("data-card_id",          value["id"])
                .attr("data-card_name",        value["name"])
                .attr("data-card_description", value["description"])
                .attr("data-card_finish_time", value["finish_time"])
                .attr("data-card_type",        value["card_type"])
                .attr("data-card_state",       value["card_state"])
                .attr("data-card_sort_number", value["card_sort_number"])
                .attr("data-card_tasks",       value["card_tasks"]);

            card.find( "h3.card-title.dashboard-title-text" ).html(value["name"]);
            // показываем иконки дополнительных свойств
            if(value["finish_time"]) {
                card.find("span.card-deadline-badge").show();
                let time_is = moment(value["finish_time"], "YYYY-MM-DD HH:mm:ss").format("DD.MM.YYYY HH:mm");
                card.find("span.card-deadline").html(time_is);
            }
            if(value["description"]) {
                card.find("span.card-comment-badge").show();
            }
            if(value["card_tasks"]) {
                card.find("span.card-tasks-badge").show();
            }
            //скрываем подвал если в нем пусто
            if(!value["finish_time"] && !value["description"] && !value["card_tasks"]) {
                card.find("div.card-footer.card-kanban-footer.clearfix").hide();
            }
            $(card).find( "button.dashboard-update-card" ).on('click', function () {
                update_card($(this).parent().parent().parent());
            });

        });
    }

    /**
     * Инициализация модуля "Срок исполнения" в карточке
     */
    let datepicker_dashboard = $('input[name="finish_time"]').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerIncrement": 15,
            "startDate": moment().startOf('hour').add(24, 'hour'),
            "autoApply": true,

            locale: {
                format: 'DD.MM.Y H:mm',
                firstDay:1,
                monthNames : ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                daysOfWeek : ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            }

        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') +
                ' (predefined range: ' + label + ')');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    datepicker_dashboard.val('');



    /**
     * Показать все клонки и карточки.
     * Первичная функция инициализации всего процесса
     */
    $.get( "/api/dashboard?project_id="+current_project_id, function( data ) {
        // сохраняем объекта данных из загрузки
        window.project_instance = data;

        $.each(data["columns"], function(index, value){
            // клонирование шаблона колонки
            let element = $( "#clone")
                .clone()
                .prependTo( ".container-columns-board" )
                .removeClass( "column-example" )
                .removeAttr( "id")
                .attr( "data-column_id",          value["id"] )
                .attr( "data-project_id",         value["id_project"] )
                .attr( "data-column_sort_number", value["column_sort_number"] )
                .attr( "data-column_state",       value["column_state"] )
                .attr( "data-column_type",        value["column_type"] )
                .attr( "data-column_name",        value["name"] )
                .attr( "data-column_description", value["description"] );

            // вывод названия колонки
            $(element).find("span.dashboard-title").html(data["columns"][index]["name"]);

            // при создании элемента навешиваем ему событие на кнопку "параметы"
            $(element).find("button.dashboard-extras").on('click', function () {
                edit_column($(this).parent().parent().parent());
            });

            //при создании вешаем на кнопку "создать задачу" событие обработки данных
            $(element).find("button.dashboard-add-card").on('click', function () {
                add_card($(this).parent());
            });

            // отображение карточек колонки
            let cards = data["cards"][data["columns"][index]["id"]]; // карточки текущей колонки
            show_cards(element, cards);
        });

        // инициализация перетаскивания карточек
        $('.connectedSortable').sortable({
            placeholder         : 'sort-highlight',
            connectWith         : '.connectedSortable',
            handle              : '.card-header, .nav-tabs',
            forcePlaceholderSize: true,
            zIndex              : 999999
        });

        // обработка событий перемещения карточек между колонок и карточек
        $('.connectedSortable').on("sortupdate", function(event, ui) {
            UpdateCardSorting(ui);
        });
    });




    /**
     * Добавлением таск-листов
     *
     * Событие вешается на кнопку "Добавить таск-лист" в блоке справа, на всплывающем окне Изменение карточки
     * Поле добавление нового заголовка таск-листа
     */
    $('#add-new-task-list').on('click', function (event){
        let block = $("div#modal-fix-card");
        let task_list = block.find('.task-list-example').clone().removeClass('task-list-example');
        let name = $("#new-task-list").val();
        let tasklist_name = task_list.find('.todo-decole-name').html(name);
        let el = block.find(".to-do-list-show");
        el.append(task_list);
        el.val('');
        $('#collapseExample').collapse('hide');
        add_event_edit_task_list(tasklist_name);
        add_event_on_button_add_task();
     });

    /**
     * В данные момент не используется.
     * Нужно при переводе страницу на ajax запросы без перезагрузки страницы
     * Обновление позиций тасков внутри таск-листа после изменения физического расположения тасков внутри таск-листа
     */
    function UpdateTaskListSorting(item) {
        let el = $(item["item"][0]).parent();
        let el_name = el.find('.todo-decole-name').html();
        let array_el = el.find('li');
        let pins = [];
        $.each(array_el, function(index, value){
            pins[index] = {
                name: $(value).find('.todo-decole-text').html(),
                done: $(value).find('input:checkbox').prop("checked"),
            };
        });

        let object = {
            name: el_name,
            pins: pins,
        };
        // @Todo функция нужна для перевода изменений в глобальную переменную. Нужно при переводе страницу на ajax
        //   запросы. Нужно переменную object передать на сохранение или доработать функцию, чтобы она заменяла нужный
        //   блок на себя
    }

    /**
     * Сохранение блока чек-листов в момент сохранения формы изменения карточки
     */
    function save_check_list(id) {
        let form_update = $(id);
        let card_id = form_update.find('input[name="card_id"]').val();
        // в форме изменения карточки вешаем событие на кнопку сохранения изменений
        let button_save = $("div#modal-fix-card").find('button[type="submit"]').on("click", function () {
            let task_list = get_all_task_lists(form_update);
            let json = JSON.stringify(task_list);
            // сохранить в глобальной переменной
            // @Todo переезд на функционал - изменение данныз без перезагрузки страницы
            save_in_global_tasks(card_id);
            // передать POST запрос на обновление блока тасков
            let post = $.post( "/api/dashboard/card/task-list/update", {
                "project_id": current_project_id,
                "card_id":card_id,
                "task_object":json
            } );
            post.done(function( data ) {
                $(document).Toasts('create', {
                    title: 'Карточка',
                    autohide: true,
                    delay: 2500,
                    body: data,
                });
            });
            return true;
        });
    }

    /**
     * Передает объект текущих тасков на форме изменения карточки для последующей обработки
     */
    function get_all_task_lists(form_update) {
        let all_tasks = form_update.find('.to-do-list-show').find('ul.todo-decole-style.todo-list.ui-sortable');
        let obj, ebs = {};
        let pins = [];

        $.each(all_tasks, function(index_list, list){
            let name = $(list).find('.todo-decole-name').html();
            pins = []; // отчищаем список, для наполнения другими тасками
            $.each($(list).find('li'), function (index_pin, pin) {
                let pini = [{
                        name: $(pin).find('.todo-decole-text').html(),
                        done: Number($(pin).find('input:checkbox').prop("checked")),
                    }];
                $.merge(pins,pini);
            });

            ebs[index_list] = {
                "name": name,
                "pins": pins,
            };
        });

        obj = {
            list: ebs,
        };

        return obj;
    }

    /**
     * По id карточки забирает данные с глобальной переменной и начинает процесс отрисовки в форме изменения карточки
     */
    function get_check_list(id) {
        let el = $(id).find("input[name='card_id']");
        $(id).find(".to-do-list-show").html(''); // очищам листинг

        $.each(window.project_instance['cards'], function(index, value){
            $.each(value, function(in_index, in_value){
                if(in_value['id'] == el.val() && in_value['card_tasks'] != null) {
                    let json = JSON.parse(in_value['card_tasks']);
                    return show_check_list(json, id);
                }
            });
        });
    }

    /**
     * Показать все чек листы на странице. При инициализации показа формы изменения карточки
     */
    function show_check_list(json, id) {
        if(json['list']){
            let el = $(id).find(".to-do-list-show");
            let i = 1;
            let parent = el.parent();

            $.each(json['list'], function(index, value){
                let task_list = $(parent).find('.task-list-example').clone().removeClass('task-list-example');
                let tasklist_name = task_list.find('.todo-decole-name').html(value['name']);
                add_event_edit_task_list(tasklist_name);
                el.append(task_list);

                // добавляем элементы списка
                $.each(value['pins'], function(key, val){
                    let name = i + '_' + key;
                    let element_list = $(parent).find('.task-list-element-example')
                        .clone()
                        .removeClass('task-list-element-example');
                    let text = element_list.find('.todo-decole-text').html(val['name']);
                    let checkbox = element_list.find('input[type="checkbox"]')
                        .removeAttr('id')
                        .attr('id', name)
                        .attr('value', val['name']);

                    element_list.find('label').removeAttr('for').attr('for', name);

                    //если элемент выделен, то зачеркнуть текст
                    checkbox.change(function() {
                        if($(this).prop('checked')) {
                            element_list.addClass('done');
                        }
                        else {
                            element_list.removeClass('done');
                        }
                    });

                    if(val['done'] == 1) {
                        checkbox.attr('checked', true);
                        $(element_list).addClass('done');
                    }
                    task_list.append(element_list);

                    // форма изменения текста в таске
                    edit_task_name(text);
                });

                // инициализация перетаскивания карточек
                sortabling_task_list(task_list);

                i++;
            });
            return true;
        }
        return false;
    }

    function sortabling_task_list(task_list) {
        task_list.sortable({
            placeholder         : 'sort-highlight',
            handle              : '.handle',
            forcePlaceholderSize: true,
            items: '> li',
            zIndex              : 999999,
            serialize: { key: "sort" },
        });
        // обработка событий перемещения карточек между колонок и карточек
        task_list.on("sortupdate", function(event, ui) {
            UpdateTaskListSorting(ui);
        });
    }

    /**
     * Функция добавления события изменения таск-листа.
     * Используется при первичной генерации таск-листа на странице и при создании нового таск-листа при последующем
     * использовании на странице
     */
    function add_event_edit_task_list(tasklist_name) {
        tasklist_name = $(tasklist_name);
        tasklist_name.on("click", function () {
            let block = tasklist_name.parent();
            let input_block = block.find('input').val(tasklist_name.html());
            let apply = block.find('button.task-list-button-apply');
            let cancel = block.find('button.task-list-button-cancel');
            let but_delete = block.find('button.task-list-button-delete');
            function show(){
                tasklist_name.hide();
                input_block.show();
                apply.show();
                cancel.show();
                but_delete.show();
            }
            function hide(){
                tasklist_name.show();
                input_block.hide();
                apply.hide();
                cancel.hide();
                but_delete.hide();
            }

            show();
            apply.on("click", function () {
                hide();
                tasklist_name.html(input_block.val());
            });
            cancel.on("click", function () {
                hide();
            });
            but_delete.on("click", function () {
                hide();
                block.parent().parent().parent().remove();
            });
        });
    }

    /**
     * Изменение названия таски
     */
    function edit_task_name(block) {
        let element_list = $(block).parent();
        let edit_button = element_list.find('i.fas.fa-edit');
        let delete_button = element_list.find('i.fas.fa-trash-alt');

        function act_edit() {
            let input_edit_block = element_list.find('.todo-decole-text-edit-hide').show();
            let input_edit = element_list.find('.todo-decole-text-edit').val(block.html());

            element_list.find('.task-list-button-apply').on("click", function () {
                block.html(input_edit.val());
                input_edit_block.hide();
            });
            element_list.find('.task-list-button-cancel').on("click", function () {
                input_edit.val('');
                input_edit_block.hide();
            });
        }

        block.on("click", function () {
            act_edit();
        });

        edit_button.on("click", function () {
            act_edit();
        });

        delete_button.on("click", function () {
            element_list.remove();
        });
    }

    /**
     * Функция не реализована.
     * Нужна для перехода функционала на ajax без перезагрузки страницы.
     * Сохраняет изменения карточки в глобальной переменной
     */
    function save_in_global_tasks(card_id){
        /*
        $.each(window.project_instance['cards'], function(index, value){
            $.each(value, function(in_index, in_value){
                if(in_value['id'] == card_id) {
                    //@Todo смержить изменения в глобальную переменную если делать функционал изменения
                    //  карточек без перезагрузки страницы
                    //let json = JSON.parse(in_value['card_tasks']);
                    //return show_check_list(json, id);

                }
            });
        });
        */
        //return true;
    }

    /**
     * Добавление таски в таск-лист
     * @param ul
     * @param name
     */
    function add_task_in_list(ul,name) {
        let varios = $.now().toString();
        let form_update = $("div#modal-fix-card");
        let element_list = form_update.find('.task-list-element-example').clone().removeClass('task-list-element-example');
        element_list.find('label').attr('for', varios);
        element_list.find('input:checkbox').attr('id', varios);
        let text = element_list.find('.todo-decole-text').html(name);
        let first_element = $(ul).find("li:first");
        if(first_element.length === 0){
            element_list.appendTo($(ul));
            // вешаем при первой же li сортировку
            sortabling_task_list($(ul));
        }
        else {
            first_element.before(element_list);
        }
        first_element = element_list = '';
        edit_task_name(text); // вешаем событие изменение вновь созданного блока
    }

    /**
     * Обработчик кнопки добавление таск листа
     */
    function add_event_on_button_add_task() {
        let form_update = $("div#modal-fix-card");
        form_update.find( "button.add-task-element-in-list" ).on('click', function () {
            let add_task_block = $(this).parent().parent().parent();
            let input = add_task_block.find(".task-decole-text-edit-input").show();
            let button_apply = add_task_block.find("button.task-list-button-text-edit-apply").show();
            let button_cancel = add_task_block.find("button.task-list-button-text-edit-cancel").show();
            let button_add_task = $(this).hide();

            // убираем старые события на кнопках - без него идет добавление события при повторном нажатии на кнопки
            button_cancel.off('click');
            button_apply.off('click');

            // вешаем новые события на кнопки
            button_apply.on('click', function () {
                add_task_in_list(add_task_block.parent().parent(), input.val());
                button_add_task.show();
                input.hide();
                input.val('');
                button_apply.hide();
                button_cancel.hide();
            });

            button_cancel.on('click', function () {
                button_add_task.show();
                input.hide();
                button_apply.hide();
                button_cancel.hide();
            });
        });
    }

});

