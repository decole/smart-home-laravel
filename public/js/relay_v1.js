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
        let $this = $(".relay-control[data-swift-topic]");
        if($this.length > 0) {
            $this.map(function (key, value) {
                let topic = $(value).data('swift-topic');
                let topic_check = $(value).data('swift-topic-check');
                $.get("/api/mqtt/get?topic="+topic_check, function (data) {
                    let payload = data['payload'];
                    $(value).find('button').map(function (keybtn, valuebtn) {
                        if ($(valuebtn).data('swift-check') == payload) {
                            $(valuebtn).addClass('active');
                        }
                        else {
                            $(valuebtn).removeClass('active');
                        }
                    });
                });
            });

            setTimeout(swiftStateRefrash, 10000);
        }
    }

    swiftStateRefrash();

});
