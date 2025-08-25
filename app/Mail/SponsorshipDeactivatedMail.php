<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use App\Models\Animal\Sponsorship;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SponsorshipDeactivatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Sponsorship $sponsorship
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vamos sentir a sua falta...',
        );
    }

    public function content(): Content
    {
        $animal = $this->sponsorship->expense->animal;
        
        return new Content(
            view: 'emails.sponsorship-deactivated',
            with: [
                'sponsorship' => $this->sponsorship,
                'animal' => $animal,
                'sponsorName' => $this->sponsorship->user->firstName,
                'animalName' => $animal->name ?? 'Animal',
                'genderedName' => $animal->gendered_name ?? $animal->name ?? 'Animal',
                'genderedArticle' => $animal->gendered_article ?? 'o/a',
                'genderedPronoun' => $animal->gendered_pronoun ?? 'ele/ela',
                'genderedPossessive' => $animal->gendered_possessive ?? 'dele/dela',
                'genderedPreposition' => $animal->gendered_preposition ?? 'do/da',
                'amount' => $this->sponsorship->amount,
                'expenseName' => $this->sponsorship->expense->name,
                'paymentLink' => $this->sponsorship->expense->payment_link,
            ]
        );
    }
}