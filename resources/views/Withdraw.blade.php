{{-- Alert Error dari Xendit --}}
                @if($errors->has('xendit'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('xendit') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Withdraw - TrashForCash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-text {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .form-header {
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container">
                <div class="form-header">
                    <h3 class="mb-0 text-center">Form Penarikan Saldo (Withdraw)</h3>
                </div>

                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Alert Error untuk koin --}}
                @if($errors->has('coin'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('coin') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Alert Error untuk auth --}}
                @if($errors->has('auth'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('auth') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('withdraw.send') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control @error('beneficiary_name') is-invalid @enderror" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                            @error('beneficiary_name')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Penerima</label>
                            <input type="email" class="form-control @error('beneficiary_email') is-invalid @enderror" name="beneficiary_email" value="{{ old('beneficiary_email') }}" required>
                            @error('beneficiary_email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control @error('beneficiary_account') is-invalid @enderror" name="beneficiary_account" value="{{ old('beneficiary_account') }}" required>
                            @error('beneficiary_account')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bank</label>
                            <select class="form-select @error('beneficiary_bank') is-invalid @enderror" name="beneficiary_bank" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="bni" {{ old('beneficiary_bank') == 'bni' ? 'selected' : '' }}>BNI</option>
                                <option value="bca" {{ old('beneficiary_bank') == 'bca' ? 'selected' : '' }}>BCA</option>
                                <option value="bri" {{ old('beneficiary_bank') == 'bri' ? 'selected' : '' }}>BRI</option>
                                <option value="mandiri" {{ old('beneficiary_bank') == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                            </select>
                            @error('beneficiary_bank')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $amount ?? '' }}" min="10000" required>
                            </div>
                            @error('amount')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal penarikan Rp 10.000</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Catatan</label>
                            <input type="text" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ old('notes') }}">
                            @error('notes')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success px-4 py-2">
                            <i class="bi bi-send-fill me-2"></i>Kirim Withdraw
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>