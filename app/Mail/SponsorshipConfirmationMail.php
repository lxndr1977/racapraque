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

class SponsorshipConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sponsorship;

    /**
     * Create a new message instance.
     */
    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
        $this->sponsorship = $sponsorship->load(['expense.animal', 'user']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quase lá! Finalize seu apadrinhamento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $animal = $this->sponsorship->expense->animal;
        
        return new Content(
            view: 'emails.sponsorship-confirmation',
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
                'recurrenceDays' => $this->sponsorship->expense->recurrence_days->getLabel(),
                'paymentLink' => $this->sponsorship->expense->payment_link,
            ],
        );
    }
}