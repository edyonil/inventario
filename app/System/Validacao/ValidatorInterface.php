<?php namespace JobsCondDev\System\Validacao;

interface ValidatorInterface
{
    /**
     * Adicionar os dados para a validação
     *
     * @param array
     * @return $this
     */
    public function with(array $input);

    /**
     * Testar se a validação passou
     *
     * @return boolean
     */
    public function passes();

    /**
     * Retorna e armazena o error
     *
     * @return array
     */
    public function errors();
}