<!DOCTYPE html>
<html>
    <style>
        .item-titre-pdf {
            text-align: center;
            font-weight: 600;
            font-size: 20px;
            border: 1px solid #000;
            padding: 5px 10px!important;
            margin-bottom: 20px!important;
        }
        .item-image-logo-pdf {
            width: 90px;
            height: 90px;
            margin-bottom: 10px;
            margin-top: -125px;
           // border: .2px solid #2b2b2b;
        }
        footer-signature {
            position: fixed;
            bottom: -55px;
            left: 0px;
            right: 0px;
            height: 6%;
            width: 100%!important;
        }

    </style>
    @if(!$is_excel)
    @include('pdf.layouts.partials.header2')
     @endif
    <body>
        @if(!$is_excel)
            <div>
                <img class="item-image-logo-pdf" src="{{Auth::user()->image ? Auth::user()->image : 'assets/images/upload.jpg'}}"   alt="">
            </div>
            <div class="item-titre-pdf">{{$titre}}</div>
        @endif
        
        @yield('content')
    </body>
</html>
