﻿<?php
/* zKillboard
 * Copyright (C) 2012-2013 EVE-KILL Team and EVSCO.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Semaphore
{
    /**
     * @param int $semaphoreID
     * @return null|resource
     */
    public static function fetch($semaphoreID)
    {
        global $useSemaphores, $semaphoreModulus;
        if (!isset($useSemaphores)) $useSemaphores = false;
        if ($useSemaphores == false) return null;
        if (!isset($semaphoreModulus)) $semaphoreModulus = 10;

        $sem = sem_get($semaphoreID % $semaphoreModulus);
        if (!sem_acquire($sem)) return null;
        return $sem;
    }

    /**
     * @param null|resource $semaphoreResource
     */
    public static function release($semaphoreResource)
    {
        if ($semaphoreResource != null) sem_release($semaphoreResource);
    }
}
