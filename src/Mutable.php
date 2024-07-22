<?php

namespace Cjfulford\Measurements;

interface Mutable
{
    public function toImmutable(): Immutable;
}