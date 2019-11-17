<?php
namespace classes;
 
class Db
{
    // �������� ��� �������� ����������� � ���� ������.
    protected $linkDb;
 
    // ����� ����������� � ���� ������.
    public function connect($config)
    {
        // ����������� � ���� ������.
        $this->linkDb = new \mysqli($config['host'], $config['username'], $config['password'],
            $config['name']);
        // ��������� ��������� utf-8.
        $this->linkDb->query("SET NAMES utf8");
    }
 
    // ����� ��������� ��� ���������� � ������������ �� ��������������� �������.
    protected function envelope($entry = false)
    {
        // �������� ���������� �� �����.
        if (is_numeric($entry)) {
            // ���������� ������������ ��� ���������.
            return $entry;
        } elseif (is_array($entry)) {
            // ���� ���������� � ������, �������������� ������ ���������� ������� ���� �� �������.
            return array_map(array('classes\Db', 'envelope'), $entry);
        }
        // ���� ���������� � ������, ����������� �������.
        return '\'' . addslashes($entry) . '\'';
    }
 
    // ����� ���������� ������ � ���� ������.
    public function query($query, $value = [])
    {
        // ���������� ��� �������� ���������� �������.
        $data = [];
        // ���������� ������ �� ��������� �� ����� �������.
        $pieces = explode('?', $query);
        // ��������� ���������� ��������.
        $entry = sizeof($pieces);
        if ($entry > 0 && sizeof($value) > 0) {
            // ��������� ������ �������.
            $query = '';
            // ��������� ���������� ������� envelope.
            $value = array_map(array("classes\Db", "envelope"), $value);
            $i = 0;
            // ������� ���� �������� �������
            foreach ($pieces as $piece) {
                // ����������� ��������� ������� �� ��������� � �������� ����������.
                $query .= $piece;
                if (array_key_exists($i, $value)) {
                    $query .= $value[$i];
                }
                $i++;
            }
        }
        // ������ � ���� ������, ��������� ������� �������� � ���������� $result;
        if ($result = $this->linkDb->query($query)) {
            // ���� �������� �� ������, ������ ��� �� �������� ������.
            if (!is_object($result)) {
                // ���������� id ��������� ������.
                return $this->linkDb->insert_id;
            }
 
            // ������ ���������� ��������� �� $result.
            while ($row = $result->fetch_assoc()) {
                // ���������� � data.
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>