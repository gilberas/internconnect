@props(['status'])

@php
$colors = [
    'pending'              => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
    'approved'             => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
    'verified'             => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
    'rejected'             => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
    'closed'               => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    'submitted'            => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
    'under_review'         => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
    'shortlisted'          => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
    'interview_scheduled'  => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
    'accepted'             => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
    'active'               => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
    'suspended'            => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
    'scheduled'            => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
    'confirmed'            => 'bg-emerald-100 text-emerald-800',
    'rescheduled'          => 'bg-amber-100 text-amber-800',
    'completed'            => 'bg-gray-100 text-gray-600',
    'cancelled'            => 'bg-red-100 text-red-800',
];
$class = $colors[$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold $class"]) }}>
    {{ ucwords(str_replace('_', ' ', $status)) }}
</span>
