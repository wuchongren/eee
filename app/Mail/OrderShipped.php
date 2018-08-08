<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    //声明属性
    public  $msg;//传递到邮件视图
    public $view;//邮件模板
    /**
     * Create a new msg instance.
     *
     * @return void
     */
    public function __construct($view,$msg)
    {

        $this->msg = $msg;
        $this->view = $view;
    }

    /**
     * Build the msg.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from("308877725@qq.com")//邮件发送方
            ->view($this->view)
            ->with(['msg'=>$this->msg]);//view为调用的邮件模板视图，message为显示到视图的信息
    }
}
