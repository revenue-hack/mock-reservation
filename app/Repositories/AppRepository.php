<?php
namespace App\Repositories;

abstract class AppRepository
{
    public function save($request)
    {
        try {
            return \DB::transaction(function () use ($request) {
                return $this->trunsactionCreate($request);
            });
        } catch (\Exception $e) {
            \Fetch::reportLog("save trunsaction error", (array) $e);
            return false;
        }
    }

    public function update($request)
    {
        try {
            return \DB::transaction(function () use ($request) {
                return $this->trunsactionUpdate($request);
            });
        } catch (\Exception $e) {
            \Fetch::reportLog("update trunsaction error", (array) $e);
            return false;
        }
    }

    public function destroy(int $id)
    {
        try {
            return \DB::transaction(function () use ($id) {
                return $this->trunsactionDestroy($id);
            });
        } catch (\Exception $e) {
            \Fetch::reportLog("destroy trunsaction error", (array) $e);
            return false;
        }
    }

    public function getFormList(string $key, string $value, array $where = array())
    {
        return $this->getQuery($where)->lists($value, $key);
    }

    //abstract protected function trunsactionCreate($request);

    //abstract protected function trunsactionUpdate($request);

    //abstract protected function trunsactionDestroy(int $id);

    abstract protected function getQuery(array $where, int $id = null);

    public function getPager(array $where = array(), int $limit = 20, array $order = ['id', 'desc'])
    {
        return $this->getQuery($where)->orderBy($order[0], $order[1])->paginate($limit);
    }

    public function getList(array $where = array(), int $limit = null, array $order = ['id', 'desc'])
    {
        $query = $this->getQuery($where)
            ->orderBy($order[0], $order[1]);
        if (!is_null($limit)) {
            $query->take($limit);
        }
        return $query->get();
    }

    public function getOneByPk(int $id)
    {
        return $this->getQuery(array(), $id)->first();
    }

    public function existRecord(array $where = array())
    {
        return $this->getQuery($where)->exists();
    }
}
