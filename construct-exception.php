<?php
class Entree {
    private $name;
    protected $ingredients = array();

    public function getName() {
        return $this->getName();
    }

    public function __construct($name, $ingredients) {
        if (!is_array($ingredients)) {
            throw new Exception("\$ingredients가 배열이 아닙니다.");
        }
        $this->name = $name;
        $this->ingredients = $ingredients;
    }

    public function hasIngredient($ingredient) {
        return in_array($ingredient, $this->ingredients);
    }
}


class ComboMeal extends Entree {

    public function __construct($name, $entrees) {
        parent::__construct($name, $entrees);
        foreach ($entrees as $entree) {
            if (!$entrees instanceof $entree) {
                throw new Exception('/$entrees의 원소는 객체여야 합니다.');
            }
        }
    }
    public function hasIngredient($ingredient) {
        foreach ($this->ingredients as $entree) {
            if ($entree->hasIngredient($ingredient)) {
                return true;
            }

            return false;
        }
    }
}
?>