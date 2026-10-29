<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui o arquivo de configuração
include 'config.php';

// Verifica se a classe Database existe
if (!class_exists('Database')) {
    echo json_encode(["success" => false, "message" => "Arquivo config.php não encontrado"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch($method) {
        case 'GET':
            if(isset($_GET['id'])) {
                getContato($_GET['id']);
            } else {
                getContatos();
            }
            break;
        
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data['id'])) {
                updateContato($data);
            } else {
                createContato($data);
            }
            break;
        
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data['id'])) {
                deleteContato($data['id']);
            } else {
                echo json_encode(["success" => false, "message" => "ID não especificado"]);
            }
            break;
            
        default:
            echo json_encode(["success" => false, "message" => "Método não permitido"]);
    }
} catch(Exception $e) {
    echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
}

function getContatos() {
    $database = new Database();
    $db = $database->getConnection();
    
    if(!$db) {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco"]);
        return;
    }
    
    $query = "SELECT * FROM contatos ORDER BY data_envio DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $contatos = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contatos[] = $row;
    }
    
    echo json_encode($contatos);
}

function getContato($id) {
    $database = new Database();
    $db = $database->getConnection();
    
    if(!$db) {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco"]);
        return;
    }
    
    $query = "SELECT * FROM contatos WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    
    $contato = $stmt->fetch(PDO::FETCH_ASSOC);
    if($contato) {
        echo json_encode($contato);
    } else {
        echo json_encode(["success" => false, "message" => "Contato não encontrado"]);
    }
}

function createContato($data) {
    // Validação básica
    if(empty($data['nome']) || empty($data['email']) || empty($data['assunto']) || empty($data['mensagem'])) {
        echo json_encode(["success" => false, "message" => "Todos os campos são obrigatórios"]);
        return;
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if(!$db) {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco"]);
        return;
    }
    
    $query = "INSERT INTO contatos (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    
    try {
        $success = $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['assunto'],
            $data['mensagem']
        ]);
        
        if($success) {
            echo json_encode(["success" => true, "message" => "Contato criado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao criar contato"]);
        }
    } catch(PDOException $exception) {
        echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $exception->getMessage()]);
    }
}

function updateContato($data) {
    $database = new Database();
    $db = $database->getConnection();
    
    if(!$db) {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco"]);
        return;
    }
    
    $query = "UPDATE contatos SET nome = ?, email = ?, assunto = ?, mensagem = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    
    try {
        $success = $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['assunto'],
            $data['mensagem'],
            $data['id']
        ]);
        
        if($success) {
            echo json_encode(["success" => true, "message" => "Contato atualizado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar contato"]);
        }
    } catch(PDOException $exception) {
        echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $exception->getMessage()]);
    }
}

function deleteContato($id) {
    $database = new Database();
    $db = $database->getConnection();
    
    if(!$db) {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco"]);
        return;
    }
    
    $query = "DELETE FROM contatos WHERE id = ?";
    $stmt = $db->prepare($query);
    
    try {
        $success = $stmt->execute([$id]);
        
        if($success) {
            echo json_encode(["success" => true, "message" => "Contato deletado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao deletar contato"]);
        }
    } catch(PDOException $exception) {
        echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $exception->getMessage()]);
    }
}
?>