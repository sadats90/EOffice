<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function certificate_type()
    {
        return $this->belongsTo(CertificateType::class);
    }

    public function onBehalfOf()
    {
        return $this->belongsTo(User::class, 'on_behalf_of');
    }

    public function certificate_duplicates()
    {
        return $this->hasMany(CertificateDuplicate::class);
    }

    public function government()
    {
        return $this->hasOne(GovernmentCertificate::class, 'certificate_id');
    }

    public function certificate_attachments()
    {
        return $this->hasMany(CertificateAttachment::class, 'certificate_id');
    }

    public function general_certificate()
    {
        return $this->hasOne(GeneralCertificate::class, 'certificate_id');
    }
}
