<?php


namespace BotConstructor\Step;

use BotConstructor\Step;

class StepService
{
    private Step $step;

    private StepRepository $repository;

    public function __construct(?int $stepId = null) {
        $this->repository = new StepRepository();
        $this->step = new Step();
        StepHydrator::hydrate($this->repository->getData($stepId), $this->step, [
            'models/User',
            'models/Rule',
            'models/BotAnswer/Message',
            'models/BotAnswer/CallbackQuery',
        ]);
    }

    /**
     * @return Step
     */
    public function getStep(): Step
    {
        return $this->step;
    }

    /**
     * @return StepRepository
     */
    public function getRepository(): StepRepository
    {
        return $this->repository;
    }


}