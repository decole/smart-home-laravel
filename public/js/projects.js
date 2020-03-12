/**
 * Скрипты для работы со страницей список проектов
 */

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let project_edit_modal_form = $('.form_project_edite').on('click', function () {
        let project_id    = $(this).data("project_id");
        let project_name  = $(this).data("project");
        let project_type  = $(this).data("project_type");
        let project_state = $(this).data("project_state");

        $("#ProjectIdName").val(project_id);
        $("#ProjectName").val(project_name);

        let el = $("#ProjectEditType").find("input[data-project_type_edit]");
        $.each(el, function(index, value){
            $(el[index]).removeAttr("checked");
        });

        el = $("#ProjectEditState").find("input[data-project_state]");
        $.each(el, function(index, value){
            $(el[index]).removeAttr("checked");
        });

        $("#ProjectEditType").find("input[data-project_type_edit='"+project_type+"']").attr("checked", true);
        $("#ProjectEditState").find("input[data-project_state_edit='"+project_state+"']").attr("checked", true);

        //console.log(project_id + ' ' + project_name);
        // $.post( "test.php", str ).done(function( data ) {
        //     alert( "Data Loaded: " + data );
        // });
    });

});

