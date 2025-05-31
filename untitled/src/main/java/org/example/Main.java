package org.example;
import java.sql.Connection;
import java.util.List;


public class Main {
    public static void main(String[] args) {
        try {
            // Obtener conexión a la base de datos
            Connection conn = DatabaseConnection.getConnection();
            CustomerDAO customerDAO = new CustomerDAOImpl(conn);

            // Datos de prueba
            long testId = 1002;
            Customer customer = new Customer(testId, "Sofia@gmail.com", "Sofia Sanchez");

            // Probar CRUD
            System.out.println("=== Añadir cliente ===");
            customerDAO.add(customer);
            System.out.println("Cliente añadido: " + customer.fullName());

            System.out.println("\n=== Buscar cliente por ID ===");
            Customer found = customerDAO.getById(testId);
            System.out.println("Cliente encontrado: " + found.fullName() + " | Email: " + found.emailAddress());

            System.out.println("\n=== Actualizar cliente ===");
            Customer updatedCustomer = new Customer(testId, "Sofia@test.com", "sofia Mendez");
            customerDAO.update(updatedCustomer);
            System.out.println("Cliente actualizado: " + updatedCustomer.fullName());

            System.out.println("\n=== Listar todos los clientes ===");
            List<Customer> allCustomers = customerDAO.getAll();
            allCustomers.forEach(c -> System.out.println(
                    "ID: " + c.customerId() + " | Nombre: " + c.fullName() + " | Email: " + c.emailAddress()
            ));

            System.out.println("\n=== Eliminar cliente ===");
            customerDAO.delete(testId);
            System.out.println("Cliente eliminado (ID: " + testId + ")");

            // Cerrar conexión
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}