<?php

if (!function_exists('calculateSkillDistribution')) {
    function calculateSkillDistribution($skills) {
        $distribution = [
            'expert' => 0,
            'advanced' => 0,
            'intermediate' => 0,
            'beginner' => 0
        ];
        
        foreach ($skills as $skill) {
            // Support 'level' atau 'percentage'
            $percentage = $skill->level ?? $skill->percentage ?? $skill['level'] ?? $skill['percentage'];
            
            if ($percentage >= 80) {
                $distribution['expert']++;
            } elseif ($percentage >= 60) {
                $distribution['advanced']++;
            } elseif ($percentage >= 40) {
                $distribution['intermediate']++;
            } else {
                $distribution['beginner']++;
            }
        }
        
        return $distribution;
    }
}