@if(config('myapp.gatMeasurementId'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('myapp.gatMeasurementId')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{config('myapp.gatMeasurementId')}}');
    </script>
@endif