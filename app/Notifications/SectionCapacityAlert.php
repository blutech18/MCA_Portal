<?php

namespace App\Notifications;

use App\Models\StudentSection;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SectionCapacityAlert extends Notification
{
    use Queueable;

    protected $section;
    protected $alertType; // 'section_full' or 'all_sections_full'
    protected $additionalData;

    /**
     * Create a new notification instance.
     */
    public function __construct(StudentSection $section, string $alertType = 'section_full', array $additionalData = [])
    {
        $this->section = $section;
        $this->alertType = $alertType;
        $this->additionalData = $additionalData;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $gradeLevel = $this->section->gradeLevel->name ?? 'Unknown';
        $strand = $this->section->strand ? ' - ' . $this->section->strand->name : '';
        
        if ($this->alertType === 'all_sections_full') {
            $totalCapacity = $this->additionalData['total_capacity'] ?? 0;
            $totalStudents = $this->additionalData['total_students'] ?? 0;
            
            return (new MailMessage)
                ->subject('⚠️ ALL SECTIONS FULL - Grade ' . $gradeLevel . $strand)
                ->error()
                ->line('**WARNING**: All sections for Grade ' . $gradeLevel . $strand . ' are now FULL!')
                ->line('**Total Students**: ' . $totalStudents . '/' . $totalCapacity)
                ->line('**Action Required**:')
                ->line('• Create additional sections, OR')
                ->line('• Manually assign students to existing sections (override capacity), OR')
                ->line('• Close enrollment for this grade level')
                ->action('Manage Sections', url('/admin/sections'))
                ->line('No more students can be automatically enrolled for this grade level until action is taken.');
        } else {
            return (new MailMessage)
                ->subject('Section Full - ' . $this->section->section_name)
                ->line('Section **' . $this->section->section_name . '** for Grade ' . $gradeLevel . $strand . ' has reached full capacity.')
                ->line('**Current Capacity**: ' . $this->section->current_count . '/' . $this->section->max_capacity)
                ->line('New students will be automatically assigned to the next available section.')
                ->action('View Sections', url('/admin/sections'));
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $gradeLevel = $this->section->gradeLevel->name ?? 'Unknown';
        $strand = $this->section->strand ? ' - ' . $this->section->strand->name : '';
        
        return [
            'section_id' => $this->section->id,
            'section_name' => $this->section->section_name,
            'grade_level' => $gradeLevel,
            'strand' => $strand,
            'alert_type' => $this->alertType,
            'current_count' => $this->section->current_count,
            'max_capacity' => $this->section->max_capacity,
            'additional_data' => $this->additionalData,
            'message' => $this->alertType === 'all_sections_full'
                ? "All sections for Grade {$gradeLevel}{$strand} are now full! ({$this->additionalData['total_students']}/{$this->additionalData['total_capacity']} students)"
                : "Section {$this->section->section_name} (Grade {$gradeLevel}{$strand}) is now full ({$this->section->current_count}/{$this->section->max_capacity} students)",
        ];
    }
    
    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        return $this->toArray($notifiable);
    }
}

