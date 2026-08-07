<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use App\Contracts\UserNotifier;
class Notify extends Facade{
    // custom facade with specific interface (UserNotifier)
    // The getFacadeAccessor() method is the magic link. It simply tells Laravel: 
    // "Whenever someone calls Notify::something(), go into the Service Container, 
    // find whatever is bound to the Notifier contract, and forward the method call to it."
    // Because your AppServiceProvider already binds Notifier to EmailNotifier, 
    // this Facade will now automatically route calls to your EmailNotifier class.
    protected static function getFacadeAccessor(){
        return UserNotifier::class;
    }
}
