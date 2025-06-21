<?php

namespace App\ValueObject;

enum State : string
{
    case INIT = "init";
    case UPDATE = "update";
    case FINALIZED = 'finalized';
}