<?php

namespace Cjfulford\Measurements;

interface Immutable
{
    public function toMutable(): Mutable;
}