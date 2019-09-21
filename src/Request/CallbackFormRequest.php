<?php

namespace App\Request;

use App\Http\RequestDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CallbackFormRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank(
     *     message="Укажите имя"
     *     )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "В имени должно быть минимум {{ limit }} символа",
     *      maxMessage = "В имени должно быть максимум {{ limit }} символов"
     * )
     * @Assert\Regex(
     *     "#[\da-zA-Z]#",
     *     match=false,
     *     message="Укажите корректное имя"
     *     )
     */
    private $name;
    /**
     * @Assert\NotBlank(
     *     message="Укажите телефон"
     *     )
     * @Assert\Regex(
     *     "#\+7\(\d{3}\)\d{3}-\d{2}-\d{2}#",
     *     message="Укажите корректный телефон"
     *     )
     */
    private $phone;
    private $subject;
    private $referer;
    
    public function __construct(Request $request)
    {
        $this->name    = trim($request->get('name', 'Не указано'));
        $this->name    = $this->name ? : 'Не указано';
        $this->phone   = trim($request->get('phone'));
        $this->subject = trim($request->get('subject', 'Заказ звонка'));
        $this->referer = $_SERVER['HTTP_REFERER'] ?? 'Нет';
        
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }
    
    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $this->referer;
    }
    
    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $field => $value) {
            $data[$field] = $value;
        }
        
        return $data;
    }
    
}