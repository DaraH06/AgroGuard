<!-- resources/views/master/navbar.blade.php -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        
        <!-- Expert Info -->
        <div class="expert-info ms-auto">
            <div class="expert-details">
                <div class="expert-name">{{ session()->get('email') }}</div>
                <div class="expert-title">Ahli Tanaman Senior</div>
            </div>
            <div class="expert-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
    </div>
</nav>