<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 7/17/16
 * Time: 9:01 PM
 */

namespace App\Services\Space;


use App\Entities\Platform\Space\Space;

class SpacePointsService
{
    protected $inputs = [
        'name' => [
            'name' => 'name',
            'title' => 'Título de la oferta',
            'content' => 'El título de la oferta es clave para captar la atención del anunciante. Ingresa un título preciso, entre 40 y 70 caracteres, que permita identificar rápida y fácilmente las características básicas de la oferta',
            'maxPoints' => 6,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 30, 'points' => 0.4 ],
                [ 'min' => 40, 'points' => 0.6 ],
                [ 'min' => 50, 'points' => 1 ]
            ]
        ],
        'description' => [
            'name' => 'description',
            'title' => 'Descripción',
            'content' => 'Describe las características de este espacio publicitario. Capta el interés y atención del anunciante, y se específico brindando información completa de beneficios, tiempos, variaciones, horarios, ubicaciones, tamaños, frecuencias de salida, y cualquier información de interés para el anunciante. El anunciante debe entender qué recibe, a cambio de su inversión',            
            'maxPoints' => 15,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 300, 'points' => 0.25 ],
                [ 'min' => 400, 'points' => 0.5 ],
                [ 'min' => 500, 'points' => 0.75 ],
                [ 'min' => 700, 'points' => 1 ]
            ]
        ],
        'impact' => [
            'name' => 'impact',
            'title' => 'Impactos estimados',
            'content' => 'Digita el número (#) de impresiones, visualizaciones, personas o audiencia que impacta este espacio publicitario durante el periodo aplicable',
            'maxPoints' => 10,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 100, 'points' => 1 ]
            ]
        ],
        'price' => [
            'name' => 'price',
            'title' => 'Precio de oferta',
            'content' => 'Haz más atractivas tus ofertas con precios llamativos y competitivos. El cliente siempre compara alternativas por precios y alcance de impactos (ROI)',
            'maxPoints' => 1,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 3, 'points' => 1 ]
            ]
        ], 
        'category_id' => [
            'name' => 'category_id',
            'type' => 'exists',
            'title' => 'Categoría',
            'content' => 'Selecciona una categoría publicitaria a la que corresponde este espacio de pauta, y luego selecciona el Formato. Esto facilita que te encuentren más rápido',
            'maxPoints' => 2,
            'actual' => 0
        ],
        'period' => [
            'name' => 'period',
            'type' => 'exists',
            'title' => 'Periocidad del espacio de pauta',
            'content' => 'Selecciona la variable que corresponda al periodo en que se cobra y ejecuta el servicio publicitario. Ejemplo: $500.000, Quincenal. $2.000.000, Trimestral',
            'maxPoints' => 1,
            'actual' => 0
        ],
        'impact_scenes' => [
            'name' => 'impactScenes',
            'type' => 'collection',
            'title' => 'Escenarios de impacto',
            'content' => 'Selecciona lugares de interés, puntos de referencia o zonas comerciales de la ciudad a donde llega tu espacio publicitario o donde son impactadas audiencias o personas. Aumenta las probabilidades de que te encuentren clientes de nicho',
            'maxPoints' => 10,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 1, 'points' => 0.25 ],
                [ 'min' => 2, 'points' => 0.5 ],
                [ 'min' => 3, 'points' => 0.75 ],
                [ 'min' => 4, 'points' => 1 ]
            ]
        ],
        'audiences' => [
            'name' => 'audiences',
            'type' => 'collection',
            'title' => 'Perfil de audiencias',
            'content' => 'Selecciona diferentes perfiles de audiencia o de personas a las que logra impactar o llegar el anunciante al adquirir este espacio publicitario. Aumenta las probabilidades de que te encuentren clientes de nicho',
            'maxPoints' => 15,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 3, 'points' => 0.25 ],
                [ 'min' => 5, 'points' => 0.5 ],
                [ 'min' => 7, 'points' => 0.75 ],
                [ 'min' => 10, 'points' => 1 ]
            ]
        ],
        'more_audiences' => [
            'name' => 'more_audiences',
            'type' => 'json',
            'title' => 'Agrega más audiencias',
            'content' => 'Digita “palabras clave” (separadas por coma) que describan otros perfiles de audiencia o sitios de interés relacionados con este espacio publicitario. Ej: Abuelas, Madres Cabeza de Familia, estudiantes, Zona T Bogotá, El Campin, Avenida Dorado',
            'maxPoints' => 10,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 3, 'points' => 0.25 ],
                [ 'min' => 5, 'points' => 0.5 ],
                [ 'min' => 7, 'points' => 0.75 ],
                [ 'min' => 10, 'points' => 1 ]
            ]
        ],
        'discount' => [
            'name' => 'discount',
            'type' => 'integer',
            'title' => 'Descuento',
            'content' => 'Puedes establecer un descuento máximo aplicable sobre el Precio Base para motivar la compra de anunciantes interesados. Este descuento No será visible desde la Plataforma y solo se negociará en privado con cada el cliente interesado',
            'maxPoints' => 10,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 5, 'points' => 0.1 ],
                [ 'min' => 10, 'points' => 0.2 ],
                [ 'min' => 20, 'points' => 0.4 ],
                [ 'min' => 30, 'points' => 0.6 ],
                [ 'min' => 40, 'points' => 0.8 ],
                [ 'min' => 50, 'points' => 1 ],
            ]
        ],
        'impact_agency' => [
            'name' => 'impact_agency',
            'title' => 'Agencia Medición (fuente de la cifra de impactos)',
            'content' => 'Escribe el nombre de la agencia de medición que valida los datos de impactos para dar mayor confianza al potencial cliente. Ej: IBOPE, EGM, Nielsen, Invamer /Gallup, etc',
            'maxPoints' => 3,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 3, 'points' => 1 ]
            ]
        ],
        'cities' => [
            'name' => 'cities',
            'type' => 'collection',
            'title' => 'Ciudades',
            'content' => 'selecciona las ciudades donde se encuentra o a donde llega este espacio publicitario. Esto facilita que te encuentren por geo-referenciación',
            'maxPoints' => 5,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 1, 'points' => 1 ]
            ]
        ],
        'photos' => [
            'name' => 'images',
            'type' => 'collection',
            'title' => 'Imágenes',
            'content' => 'Incluye imágenes atractivas que describan o exhiban este espacio Publicitario. Imágenes de impacto aumentan el interés de potenciales compradores, y son un factor de confiabilidad en la decisión de compra. Las imágenes NO pueden tener marcas de agua con el nombre del Medio Publicitario, datos de contacto, direcciones web, etc',
            'maxPoints' => 12,
            'actual' => 0,
            'rules' => [
                [ 'min' => 0, 'points' => 0 ],
                [ 'min' => 1, 'points' => 0.17 ],
                [ 'min' => 2, 'points' => 0.34 ],
                [ 'min' => 3, 'points' => 0.48 ],
                [ 'min' => 4, 'points' => 0.65 ],
                [ 'min' => 5, 'points' => 0.84 ],
                [ 'min' => 6, 'points' => 1 ]
            ]
        ]
    ];

    /**
     * @return array
     */
    protected function getInputs()
    {
        return $this->inputs;
    }

    /**
     * @param $inputName
     * @return bool
     */
    protected function inputExists($inputName)
    {
        return array_key_exists($inputName, $this->getInputs());
    }

    /**
     * @param $input
     * @param $attribute
     * @return bool
     */
    protected function hasAttribute(array $input, $attribute)
    {
        return array_key_exists($attribute, $input);
    }

    /**
     * @param $inputName
     * @param $attribute
     * @return bool
     */
    protected function inputHasAttribute($inputName, $attribute)
    {
        if($this->inputExists($inputName)) {
            return $this->hasAttribute($this->getInput($inputName), $attribute);
        }

        return false;
    }

    /**
     * @param array $input
     * @param $attribute
     * @return mixed
     */
    protected function getAttribute(array $input, $attribute)
    {
        if($this->hasAttribute($input, $attribute)) {
            return $input[$attribute];
        }
    }

    /**
     * @param $inputName
     * @param $attribute
     * @return mixed
     */
    protected function getInputAttribute($inputName, $attribute)
    {
        if($this->inputHasAttribute($inputName, $attribute))
        {
            return $this->getAttribute($this->getInput($inputName), $attribute);
        }

        return null;
    }

    /**
     * @param $inputName
     * @return null
     */
    protected function getInput($inputName)
    {
        if($this->inputExists($inputName))
        {
            return $this->getInputs()[$inputName];
        }

        return null;
    }

    /**
     * @param $input
     * @return bool
     */
    protected function hasRules($input)
    {
        return $this->hasAttribute($input, 'rules');
    }

    /**
     * @param $inputName
     * @return bool
     */
    protected function inputHasRules($inputName)
    {
        return $this->inputHasAttribute($inputName, 'rules');
    }

    /**
     * @param $inputName
     * @return mixed
     */
    protected function getInputRules($inputName)
    {
        return $this->getInputAttribute($inputName, 'rules');
    }

    /**
     * @param array $input
     * @return mixed
     */
    protected function getRules(array $input)
    {
        return $this->getAttribute($input, 'rules');
    }

    /**
     * @param array $rules
     * @param $value
     * @return null
     */
    protected function findRules(array $rules, $value)
    {
        foreach($rules as $rule) {
            if($rule >= $value) {
                return $rule;
            }
        }

        return null;
    }

    /**
     * @param $inputName
     * @param $value
     * @return mixed
     */
    protected function getInputRule($inputName, $value)
    {
        return $this->findRules($this->getInputRules($inputName), $value);
    }

    /**
     * @param array $input
     * @param $value
     * @return null
     */
    protected function getRule(array $input, $value)
    {
        return $this->findRules($this->getRules($input), $value);
    }

    /**
     * @param $inputName
     * @param $value
     * @return int
     */
    protected function calculateInput($inputName, $value)
    {
        if($input = $this->getInput($inputName)) {
            return $this->calculate($input, $value);
        }
    }


    /**
     * @param array $input
     * @param int $value
     * @return int|mixed
     */
    protected function calculate(array $input, $value = 0) {
        if($this->hasAttribute($input, 'maxPoints')) {
            if($rule = $this->getRule($input, $value)) {
                return $this->getAttribute($input, 'maxPoints') * $rule['points'];
            }

            return $input['maxPoints'];
        }

        return 0;
    }

    /**
     * @param $inputName
     * @param $inputString
     * @return int
     */
    protected function calculateInputString($inputName, $inputString)
    {
        return $this->calculateInput($inputName, strlen($inputString));
    }

    /**
     * @param array $input
     * @param $inputString
     * @return int
     */
    protected function calculateString(array $input, $inputString)
    {
        return $this->calculate($input, strlen($inputString));
    }


    /**
     * @param Space $space
     * @return int|mixed
     */
    public function calculatePoints(Space $space)
    {
        $points = 0;

        foreach($this->getInputs() as $inputName => $input) {

            $spaceAttribute = $this->getAttribute($input, 'name');
            $type = $this->getAttribute($input, 'type');

            if($type == 'exists') {
                if( ! is_null($space->$spaceAttribute)) {
                    $points += $this->calculate($input);
                }
            }
            else if($type == 'collection') {
                $points += $this->calculate($input, $space->$spaceAttribute->count());
            }
            else if($type == 'json') {
                $points += $this->calculate($input, count(explode(',', $space->$spaceAttribute)));
            }
            else if($type == 'integer') {
                $points += $this->calculate($input, $space->$spaceAttribute);
            }
            else {
                $points += $this->calculateString($input, $space->$spaceAttribute);
            }
        }

        return $points;
    }

}