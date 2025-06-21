{{-- resources/views/auth/verify.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>メール認証</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    @include('fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">

                    @if(session('successMessage'))
                        <div class="alert alert-info">
                            {{ session('successMessage') }}
                        </div>
                    @endif

                    @if(session('errorMessage'))
                        <div class="alert alert-danger">
                            {{ session('errorMessage') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>

    @include('fragment.footer')
</div>
@include('fragment.scripts')
</body>
</html>
