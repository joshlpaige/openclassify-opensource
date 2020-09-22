<?php namespace Visiosoft\ProfileModule\Profile\User;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\UsersModule\User\UserModel;
use Visiosoft\NotificationsModule\Notify\Notification\UserUpdateEmailMail;
use Visiosoft\ProfileModule\Events\UserUpdated;

class UserFormHandler
{
    public function handle(
        UserFormBuilder $builder,
        MessageBag $messages,
        UserModel $userModel
    )
    {
        if (!$builder->canSave()) {
            return;
        }

        $data = $builder->getPostData();

        $user = $userModel->find(\auth()->id());
        if ($user->email != $data['email']) {
            $user->notify(new UserUpdateEmailMail());
        }

        $oldCustomerInfo = $user->toArray();

        $changes = $this->change($user, $data);

        event(new UserUpdated($oldCustomerInfo, $changes));

        $messages->success(trans('visiosoft.module.profile::message.success_update'));
    }

    public function change($user, $data)
    {
        $user->fill($data);
        $changes = $user->getDirty();
        $user->save();
        if (count($changes) == 0) {
            return false;
        }
        return $changes;
    }
}
