<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Demo Room') }}
        </h2>
    </x-slot>

    <div id="publisher" style="height: 250px; width:250px"></div>
    <div id="subscriber" style="height: 250px; width:250px"></div>

    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
    <script type="text/javascript">
        // Handling all of our errors here by alerting them
        function handleError(error) {
            if (error) {
                alert(error.message);
            }
        }
        initializeSession();

        function initializeSession() {
            const session = OT.initSession('{{ $apiKey }}', '{{ $sessionId }}');

            // Subscribe to a newly created stream
            session.on("streamCreated", function(event) {
                session.subscribe(
                    event.stream,
                    "subscriber", {
                        insertMode: "append",
                        width: "100%",
                        height: "100%",
                    },
                    handleError
                );
            });

            // Create a publisher
            const publisher = OT.initPublisher(
                "publisher", {
                    insertMode: "append",
                    width: "100%",
                    height: "100%",
                }, handleError);

            // Connect to the session
            session.connect('{{ $token }}', function(error) {
                // If the connection is successful, publish to the session
                if (error) {
                    handleError(error);
                } else {
                    session.publish(publisher, handleError);
                }
            });

            // session.on('streamCreated', function(event) {
            //     session.subscribe(event.stream, 'subscriber', {
            //         insertMode: 'append',
            //         width: '100%',
            //         height: '100%'
            //     }, handleError);
            // });
        }
    </script>
</x-app-layout>
