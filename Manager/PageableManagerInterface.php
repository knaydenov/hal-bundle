<?phpnamespace Kna\HalBundle\Manager;use Kna\HalBundle\Filter\FilterInterface;use Pagerfanta\Pagerfanta;interface PageableManagerInterface{    /**     * @param FilterInterface $filter     * @return Pagerfanta     */    public function getPager(FilterInterface $filter): Pagerfanta;}