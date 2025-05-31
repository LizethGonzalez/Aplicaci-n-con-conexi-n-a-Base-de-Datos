import org.example.Customer;
import org.example.CustomerDAO;
import org.example.CustomerDAOImpl;
import org.example.DatabaseConnection;
import org.junit.jupiter.api.*;
import static org.junit.jupiter.api.Assertions.*;
import java.sql.Connection;
import java.util.List;

class CustomerDAOTest {

    private static Connection conn;
    private static CustomerDAO customerDAO;

    @BeforeAll
    static void setUp() throws Exception {
        conn = DatabaseConnection.getConnection();
        customerDAO = new CustomerDAOImpl(conn);
    }

    @AfterAll
    static void tearDown() throws Exception {
        if (conn != null && !conn.isClosed()) {
            conn.close();
        }
    }

    @Test
    void testCRUDOperations() throws Exception {
        long testId = 9991L;
        Customer customer = new Customer(testId, "example@email.com", "Juan Pérez");

        // Crear
        customerDAO.add(customer);

        // Leer
        Customer retrieved = customerDAO.getById(testId);
        assertNotNull(retrieved);
        assertEquals("Juan Pérez", retrieved.fullName());

        // Actualizar
        Customer updated = new Customer(testId, "nuevo@email.com", "Juan P.");
        customerDAO.update(updated);
        Customer retrievedUpdated = customerDAO.getById(testId);
        assertEquals("Juan P.", retrievedUpdated.fullName());
        assertEquals("nuevo@email.com", retrievedUpdated.emailAddress());

        // Leer todos
        List<Customer> allCustomers = customerDAO.getAll();
        assertTrue(allCustomers.stream().anyMatch(c -> c.customerId() == testId));

        // Eliminar
        customerDAO.delete(testId);
        assertNull(customerDAO.getById(testId));
    }
}