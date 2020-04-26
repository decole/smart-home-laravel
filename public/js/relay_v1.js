$(document).ready(function() {

    $(".relay-control[data-swift-topic] > button").click(function () {
        let $this = $(this);
        let topic = $this.parent().data('swift-topic');
        let obj = $this.parent();

        $.post( "/api/mqtt/post", { topic: topic, payload: $this.val() })
            .fail(function() { alert( "error posting to swift" ) })
            .done(function( data ) { console.log( data ); });

        obj.find('button').map(function (keybtn, valuebtn) {
            $(valuebtn).removeClass('active');
        });
        $this.addClass('active');
    });


    function swiftStateRefrash() {
        if($("div").is($(".relay-control"))) {
            let $this = $(".relay-control[data-swift-topic]");
            $this.map(function (key, value) {
                let topic = $(value).data('swift-topic');
                let topic_check = $(value).data('swift-topic-check');
                checkStateTopic(topic_check, $this);
            });

            setTimeout(swiftStateRefrash, 10000);
        }
    }

    function checkStateTopic(topic_check, obj) {
        $.get("/api/mqtt/get?topic="+topic_check, function (data) {
            let payload = data['payload'];
            $(obj).find('button').map(function (keybtn, valuebtn) {
                if ($(valuebtn).data('swift-check') == payload) {
                    $(valuebtn).addClass('active');
                }
                else {
                    $(valuebtn).removeClass('active');
                }
            });
        });
    }

    swiftStateRefrash();

});
