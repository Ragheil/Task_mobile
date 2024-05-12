import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet } from 'react-native';

const Login: React.FC = () => {
  const [formData, setFormData] = useState({
    username: '',
    admin_password: '',
  });

  const handleLogin = async () => {
    try {
      const response = await fetch('http://192.168.1.159/app/app/server/Admin_Class.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const responseData = await response.json();

      if (responseData.success) {
        // Update state or perform navigation upon successful login
        console.log('Login successful');
      } else {
        // Update state to display login error message
        console.error(responseData.message || 'An error occurred during login.');
      }
    } catch (error) {
      console.error('Error during login:', error);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Task Management System2</Text>
      <View style={styles.formContainer}>
        <Text style={styles.formHeading}>Login Panel</Text>
        <TextInput
          style={styles.input}
          placeholder="Username"
          onChangeText={text => setFormData({ ...formData, username: text })}
          value={formData.username}
        />
        <TextInput
          style={styles.input}
          placeholder="Password"
          onChangeText={text => setFormData({ ...formData, admin_password: text })}
          value={formData.admin_password}
          secureTextEntry
        />
        <TouchableOpacity style={styles.button} onPress={handleLogin}>
          <Text style={styles.buttonText}>Login</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#fff',
    
  },
  title: {
    textAlign: 'center',
    fontSize: 24,
    marginVertical: 10,
  },
  formContainer: {
    backgroundColor: '#fff',
    paddingHorizontal: 20,
    paddingVertical: 30,
    borderRadius: 8,
    elevation: 3,
  },
  formHeading: {
    fontSize: 20,
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 4,
    padding: 10,
    marginBottom: 10,
  },
  button: {
    backgroundColor: '#007bff',
    padding: 12,
    borderRadius: 4,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
});

export default Login;
