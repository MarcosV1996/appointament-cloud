<?php
function traduzirStatus($status) {
    $traducoes = [
        'scheduled' => 'Agendado',
        'completed' => 'Concluído',
        'cancelled' => 'Cancelado'
    ];
    return $traducoes[strtolower($status)] ?? ucfirst($status);
}

function traduzirServico($servico) {
    $traducoes = [
        'social' => 'Social',
        'psychological' => 'Psicológico',
        'legal' => 'Jurídico',
        'medical' => 'Médico'
    ];
    return $traducoes[strtolower($servico)] ?? ucfirst($servico);
}