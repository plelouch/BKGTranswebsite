<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePassword
{

    /**
     * @Assert\NotBlank(message="Ce champ ne peut etre vide")
     */
    private $odlPassword;

    /**
     * @Assert\Length(min="8", minMessage="Votre mots de passe doient faire 8 caracètere au minimun")
     * @Assert\NotBlank(message="Ce champ ne peut etre vide")
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword")
     * @Assert\NotBlank(message="Ce champ ne peut etre vide")
     */
    private $confirmPassword;

    public function getOdlPassword(): ?string
    {
        return $this->odlPassword;
    }

    public function setOdlPassword(string $odlPassword): self
    {
        $this->odlPassword = $odlPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
